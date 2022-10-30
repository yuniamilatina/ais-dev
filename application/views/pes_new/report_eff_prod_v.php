<style type="text/css">
    th, td { white-space: nowrap; }
    div.dataTables_wrapper {
        margin: 0 auto;
    }
    #table-luar{
        font-size: 11px;
    }
    #filter { 
        border-spacing: 0px 10px;
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

    .legend {
        padding: 15px;
        margin-top: 5px;
        margin-bottom: 5px;
        /* border: 1px solid transparent; */
        /* border-radius: 4px; */
        /* border-left-width: 0.4em;
        border-left-color: #bce8f1; */
    }

    .legend-info {
        color: #31708f;
        background-color: #d9edf7;
        /* border-color: #bce8f1; */
        border-left-width: 0.4em;
        border-left-color: #bce8f1;
}
</style>

<script>     
    var tableToExcel = (function () {
    var uri = 'data:application/vnd.ms-excel;base64,'
    , template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>'
                , base64 = function (s) {
    return window.btoa(unescape(encodeURIComponent(s)))
        }
    , format = function (s, c) {
    return s.replace(/{(\w+)}/g, function (m, p) {
        return c[p];
    })
    }
    return function (table, name) {
    if (!table.nodeType)
        table = document.getElementById(table)
    var ctx = {worksheet: name || 'Sheet1', table: table.innerHTML}
    window.location.href = uri + base64(format(template, ctx))
    }
    })()
</script>

<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/'); ?>"><span>Home</span></a></li>
            <li><a href="">REPORT EFFICIENCY</a></li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-th-large"></i>
                        <span class="grid-title"><strong>REPORT EFFICIENCY (%)</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                    <div class="pull">
                            <table width="100%" id='filter' style="margin-bottom:-20px;">
                                <tr>
                                    <td style="text-align:top" width="15%">
                                       
                                    </td>
                                    <td style="text-align:top" width="15%">
                                            
                                    </td>
                                    <td width="75%" style="text-align:right;">
                                        <input type="button" class="btn btn-primary" onclick="tableToExcel('exportToExcel', 'Prod. per product')" value="Export to Excel" style="margin-bottom: 20px;">
                                    </td>
                               </tr>
                            </table>
                        </div>
                        <div id="table-luar">
                            <table id="example" class="table table-condensed table-bordered table-striped table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr class='gradeX'>
                                        <th style="text-align: center;">No</th>
                                        <th style="text-align: center;">Group Product</th>
                                        <th style="text-align: center;">Work Center</th>
                                        <th style="text-align: center;"><?php echo $data_weekly->weekstart1. ' - '.$data_weekly->weekend1; ?></th>
                                        <th style="text-align: center;"><?php echo $data_weekly->weekstart2. ' - '.$data_weekly->weekend2; ?></th>
                                        <th style="text-align: center;"><?php echo $data_weekly->weekstart3. ' - '.$data_weekly->weekend3; ?></th>
                                        <th style="text-align: center;"><?php echo $data_weekly->weekstart4. ' - '.$data_weekly->weekend4; ?></th>
                                        <th style="text-align: center;"><?php echo $data_weekly->weekstart5. ' - '.$data_weekly->weekend5; ?></th>
                                        <th style="text-align: center;">MIN</th>
                                        <th style="text-align: center;">MAX</th>
                                        <th style="text-align: center;">AVG</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $r = 1;
                                    foreach ($data_effiency as $isi) {
                                        echo "<tr style='text-align:center;border-right-width: 0;'>";
                                        echo "<td style=text-align:center;>$r</td>";
                                        echo "<td style=text-align:center;>$isi->CHR_PRODUCT_GROUP</td>";
                                        echo "<td style=text-align:center;>$isi->CHR_WORK_CENTER</td>";
                                        echo "<td style=text-align:center;>$isi->WEEK1</td>";
                                        echo "<td style=text-align:center;>$isi->WEEK2</td>";
                                        echo "<td style=text-align:center;>$isi->WEEK3</td>";
                                        echo "<td style=text-align:center;>$isi->LAST_WEEK</td>";
                                        echo "<td style=text-align:center;>$isi->THIS_WEEK</td>";
                                        echo "<td style=text-align:center;>$isi->MIN</td>";
                                        echo "<td style=text-align:center;>$isi->MAX</td>";
                                        echo "<td style=text-align:center;>$isi->AVG</td>";
                                        ?>
                                        </tr>
                                        <?php
                                        $r++;
                                    }
                                    ?>
                                </tbody>
                            </table>

                            <table id="exportToExcel" class="table table-condensed table-bordered table-striped display" cellspacing="0" width="100%"  style="display:none;">
                                <thead>
                                    <tr class='gradeX'>
                                        <th style="text-align: center;">No</th>
                                        <th style="text-align: center;">Group Product</th>
                                        <th style="text-align: center;">Work Center</th>
                                        <th style="text-align: center;"><?php echo $data_weekly->weekstart1. ' - '.$data_weekly->weekend1 ?></th>
                                        <th style="text-align: center;"><?php echo $data_weekly->weekstart2. ' - '.$data_weekly->weekend2 ?></th>
                                        <th style="text-align: center;"><?php echo $data_weekly->weekstart3. ' - '.$data_weekly->weekend3 ?></th>
                                        <th style="text-align: center;"><?php echo $data_weekly->weekstart4. ' - '.$data_weekly->weekend4 ?></th>
                                        <th style="text-align: center;"><?php echo $data_weekly->weekstart5. ' - '.$data_weekly->weekend5 ?></th>
                                        <th style="text-align: center;">MIN</th>
                                        <th style="text-align: center;">MAX</th>
                                        <th style="text-align: center;">AVG</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $r = 1;
                                    foreach ($data_effiency as $isi) {
                                        echo "<tr style='text-align:center;border-right-width: 0;'>";
                                        echo "<td style=text-align:center;>$r</td>";
                                        echo "<td style=text-align:center;>$isi->CHR_PRODUCT_GROUP</td>";
                                        echo "<td style=text-align:center;>$isi->CHR_WORK_CENTER</td>";
                                        echo "<td style=text-align:center;>$isi->WEEK1</td>";
                                        echo "<td style=text-align:center;>$isi->WEEK2</td>";
                                        echo "<td style=text-align:center;>$isi->WEEK3</td>";
                                        echo "<td style=text-align:center;>$isi->LAST_WEEK</td>";
                                        echo "<td style=text-align:center;>$isi->THIS_WEEK</td>";
                                        echo "<td style=text-align:center;>$isi->MIN</td>";
                                        echo "<td style=text-align:center;>$isi->MAX</td>";
                                        echo "<td style=text-align:center;>$isi->AVG</td>";
                                        ?>
                                        </tr>
                                        <?php
                                        $r++;
                                    }
                                    ?>
                                </tbody>
                            </table>

                                <div class='pull'>
                                    <div class = 'legend legend-info'>
                                        <strong>Formula : </strong> Average per week (Qty / (Work Time / CT ) * 100%) 
                                    </div >
                                </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-th-large"></i>
                        <span class="grid-title"><strong>REPORT EFFICIENCY PERDATE(%)</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                    <div class="pull">
                            <table width="100%" id='filter' style="margin-bottom:-20px;">
                                <tr>
                                    <td style="text-align:top" width="15%">
                                       
                                    </td>
                                    <td style="text-align:top" width="15%">
                                            
                                    </td>
                                    <td width="75%" style="text-align:right;">
                                        <input type="button" class="btn btn-primary" onclick="tableToExcel('exportToExcel2', 'Prod. per product')" value="Export to Excel" style="margin-bottom: 20px;">
                                    </td>
                               </tr>
                            </table>
                        </div>
                        <div id="table-luar">
                            <table id="example2" class="table table-condensed table-bordered table-striped table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr class='gradeX'>
                                        <th style="text-align: center;">No</th>
                                        <th style="text-align: center;">Work Center</th>
                                        <th style="text-align: center;">1</th>
                                        <th style="text-align: center;">2</th>
                                        <th style="text-align: center;">3</th>
                                        <th style="text-align: center;">4</th>
                                        <th style="text-align: center;">5</th>
                                        <th style="text-align: center;">6</th>
                                        <th style="text-align: center;">7</th>
                                        <th style="text-align: center;">8</th>
                                        <th style="text-align: center;">9</th>
                                        <th style="text-align: center;">10</th>
                                        <th style="text-align: center;">11</th>
                                        <th style="text-align: center;">12</th>
                                        <th style="text-align: center;">13</th>
                                        <th style="text-align: center;">14</th>
                                        <th style="text-align: center;">15</th>
                                        <th style="text-align: center;">16</th>
                                        <th style="text-align: center;">17</th>
                                        <th style="text-align: center;">18</th>
                                        <th style="text-align: center;">19</th>
                                        <th style="text-align: center;">20</th>
                                        <th style="text-align: center;">21</th>
                                        <th style="text-align: center;">22</th>
                                        <th style="text-align: center;">23</th>
                                        <th style="text-align: center;">24</th>
                                        <th style="text-align: center;">25</th>
                                        <th style="text-align: center;">26</th>
                                        <th style="text-align: center;">27</th>
                                        <th style="text-align: center;">28</th>
                                        <th style="text-align: center;">29</th>
                                        <th style="text-align: center;">30</th>
                                        <th style="text-align: center;">31</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $r = 1;
                                    foreach ($data_monthly as $isi) {
                                        echo "<tr style='text-align:center;border-right-width: 0;'>";
                                        echo "<td style=text-align:center;>$r</td>";
                                        echo "<td style=text-align:center;>$isi->CHR_WORK_CENTER</td>";
                                        echo "<td style=text-align:center;>$isi->DATE_1</td>";
                                        echo "<td style=text-align:center;>$isi->DATE_2</td>";
                                        echo "<td style=text-align:center;>$isi->DATE_3</td>";
                                        echo "<td style=text-align:center;>$isi->DATE_4</td>";
                                        echo "<td style=text-align:center;>$isi->DATE_5</td>";
                                        echo "<td style=text-align:center;>$isi->DATE_6</td>";
                                        echo "<td style=text-align:center;>$isi->DATE_7</td>";
                                        echo "<td style=text-align:center;>$isi->DATE_8</td>";
                                        echo "<td style=text-align:center;>$isi->DATE_9</td>";
                                        echo "<td style=text-align:center;>$isi->DATE_10</td>";
                                        echo "<td style=text-align:center;>$isi->DATE_11</td>";
                                        echo "<td style=text-align:center;>$isi->DATE_12</td>";
                                        echo "<td style=text-align:center;>$isi->DATE_13</td>";
                                        echo "<td style=text-align:center;>$isi->DATE_14</td>";
                                        echo "<td style=text-align:center;>$isi->DATE_15</td>";
                                        echo "<td style=text-align:center;>$isi->DATE_16</td>";
                                        echo "<td style=text-align:center;>$isi->DATE_17</td>";
                                        echo "<td style=text-align:center;>$isi->DATE_18</td>";
                                        echo "<td style=text-align:center;>$isi->DATE_19</td>";
                                        echo "<td style=text-align:center;>$isi->DATE_20</td>";
                                        echo "<td style=text-align:center;>$isi->DATE_21</td>";
                                        echo "<td style=text-align:center;>$isi->DATE_22</td>";
                                        echo "<td style=text-align:center;>$isi->DATE_23</td>";
                                        echo "<td style=text-align:center;>$isi->DATE_24</td>";
                                        echo "<td style=text-align:center;>$isi->DATE_25</td>";
                                        echo "<td style=text-align:center;>$isi->DATE_26</td>";
                                        echo "<td style=text-align:center;>$isi->DATE_27</td>";
                                        echo "<td style=text-align:center;>$isi->DATE_28</td>";
                                        echo "<td style=text-align:center;>$isi->DATE_29</td>";
                                        echo "<td style=text-align:center;>$isi->DATE_30</td>";
                                        echo "<td style=text-align:center;>$isi->DATE_31</td>";
                                        
                                        ?>
                                        </tr>
                                        <?php
                                        $r++;
                                    }
                                    ?>
                                </tbody>
                            </table>

                            <table id="exportToExcel2" class="table table-condensed table-bordered table-striped display" cellspacing="0" width="100%"  style="display:none;">
                            <thead>
                                    <tr class='gradeX'>
                                        <th style="text-align: center;">No</th>
                                        <th style="text-align: center;">Work Center</th>
                                        <th style="text-align: center;">1</th>
                                        <th style="text-align: center;">2</th>
                                        <th style="text-align: center;">3</th>
                                        <th style="text-align: center;">4</th>
                                        <th style="text-align: center;">5</th>
                                        <th style="text-align: center;">6</th>
                                        <th style="text-align: center;">7</th>
                                        <th style="text-align: center;">8</th>
                                        <th style="text-align: center;">9</th>
                                        <th style="text-align: center;">10</th>
                                        <th style="text-align: center;">11</th>
                                        <th style="text-align: center;">12</th>
                                        <th style="text-align: center;">13</th>
                                        <th style="text-align: center;">14</th>
                                        <th style="text-align: center;">15</th>
                                        <th style="text-align: center;">16</th>
                                        <th style="text-align: center;">17</th>
                                        <th style="text-align: center;">18</th>
                                        <th style="text-align: center;">19</th>
                                        <th style="text-align: center;">20</th>
                                        <th style="text-align: center;">21</th>
                                        <th style="text-align: center;">22</th>
                                        <th style="text-align: center;">23</th>
                                        <th style="text-align: center;">24</th>
                                        <th style="text-align: center;">25</th>
                                        <th style="text-align: center;">26</th>
                                        <th style="text-align: center;">27</th>
                                        <th style="text-align: center;">28</th>
                                        <th style="text-align: center;">29</th>
                                        <th style="text-align: center;">30</th>
                                        <th style="text-align: center;">31</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $r = 1;
                                    foreach ($data_monthly as $isi) {
                                        echo "<tr style='text-align:center;border-right-width: 0;'>";
                                        echo "<td style=text-align:center;>$r</td>";
                                        echo "<td style=text-align:center;>$isi->CHR_WORK_CENTER</td>";
                                        echo "<td style=text-align:center;>$isi->DATE_1</td>";
                                        echo "<td style=text-align:center;>$isi->DATE_2</td>";
                                        echo "<td style=text-align:center;>$isi->DATE_3</td>";
                                        echo "<td style=text-align:center;>$isi->DATE_4</td>";
                                        echo "<td style=text-align:center;>$isi->DATE_5</td>";
                                        echo "<td style=text-align:center;>$isi->DATE_6</td>";
                                        echo "<td style=text-align:center;>$isi->DATE_7</td>";
                                        echo "<td style=text-align:center;>$isi->DATE_8</td>";
                                        echo "<td style=text-align:center;>$isi->DATE_9</td>";
                                        echo "<td style=text-align:center;>$isi->DATE_10</td>";
                                        echo "<td style=text-align:center;>$isi->DATE_11</td>";
                                        echo "<td style=text-align:center;>$isi->DATE_12</td>";
                                        echo "<td style=text-align:center;>$isi->DATE_13</td>";
                                        echo "<td style=text-align:center;>$isi->DATE_14</td>";
                                        echo "<td style=text-align:center;>$isi->DATE_15</td>";
                                        echo "<td style=text-align:center;>$isi->DATE_16</td>";
                                        echo "<td style=text-align:center;>$isi->DATE_17</td>";
                                        echo "<td style=text-align:center;>$isi->DATE_18</td>";
                                        echo "<td style=text-align:center;>$isi->DATE_19</td>";
                                        echo "<td style=text-align:center;>$isi->DATE_20</td>";
                                        echo "<td style=text-align:center;>$isi->DATE_21</td>";
                                        echo "<td style=text-align:center;>$isi->DATE_22</td>";
                                        echo "<td style=text-align:center;>$isi->DATE_23</td>";
                                        echo "<td style=text-align:center;>$isi->DATE_24</td>";
                                        echo "<td style=text-align:center;>$isi->DATE_25</td>";
                                        echo "<td style=text-align:center;>$isi->DATE_26</td>";
                                        echo "<td style=text-align:center;>$isi->DATE_27</td>";
                                        echo "<td style=text-align:center;>$isi->DATE_28</td>";
                                        echo "<td style=text-align:center;>$isi->DATE_29</td>";
                                        echo "<td style=text-align:center;>$isi->DATE_30</td>";
                                        echo "<td style=text-align:center;>$isi->DATE_31</td>";
                                        
                                        ?>
                                        </tr>
                                        <?php
                                        $r++;
                                    }
                                    ?>
                                </tbody>
                            </table>

                                <div class='pull'>
                                    <div class = 'legend legend-info'>
                                        <strong>Formula : </strong>  Qty / (Work Time / CT ) * 100%
                                    </div >
                                </div>

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
<script>
                                                $(document).ready(function () {

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
                                                        order: [[1, 'asc']],
                                                        fixedColumns: {
                                                            leftColumns: 2
                                                        }
                                                    });

                                                    table.on('order.dt search.dt', function () {
                                                        table.column(0, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i) {
                                                            //cell.innerHTML = i + 1;
                                                        });
                                                    }).draw();

                                                    var table = $('#example2').DataTable({
                                                        scrollY: "400px",
                                                        scrollX: true,
                                                        scrollCollapse: true,
                                                        paging: false,
                                                        columnDefs: [{
                                                                sortable: false,
                                                                "class": "index",
                                                                targets: 0
                                                            }],
                                                        order: [[1, 'asc']],
                                                        fixedColumns: {
                                                            leftColumns: 2
                                                        }
                                                    });

                                                    table.on('order.dt search.dt', function () {
                                                        table.column(0, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i) {
                                                            //cell.innerHTML = i + 1;
                                                        });
                                                    }).draw();

                                                });

</script>