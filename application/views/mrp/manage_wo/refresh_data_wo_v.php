<style type="text/css">
    th,
    td {
        white-space: nowrap;
    }

    div.dataTables_wrapper {
        margin: 0 auto;
    }

    #table-luar {
        font-size: 11px;
    }

    #filter {
        border-spacing: 10px;
        border-collapse: separate;
    }

    .td-fixed {
        width: 30px;
    }

    .td-no {
        width: 10px;
    }

    .ddl {
        width: 100px;
        height: 30px;
    }

    .ddl2 {
        width: 180px;
        height: 30px;
    }
</style>
<table id="example2" class="table table-condensed table-bordered table-striped table-hover display" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th rowspan="1" style="vertical-align: middle">No</th>
            <th rowspan="1" style="vertical-align: middle">Part No Cust</th>
            <th rowspan="1" style="vertical-align: middle">Part No AII</th>
            <th rowspan="1" style="vertical-align: middle">Part Name</th>
            <th rowspan="1" style="vertical-align: middle">Cust Code</th>
            <!-- <th rowspan="1" style="vertical-align: middle">Month</th>
            <th rowspan="1" style="vertical-align: middle">Version</th> -->
            <th rowspan="1" style="vertical-align: middle">Day 1</th>
            <th rowspan="1" style="vertical-align: middle">Day 2</th>
            <th rowspan="1" style="vertical-align: middle">Day 3</th>
            <th rowspan="1" style="vertical-align: middle">Day 4</th>
            <th rowspan="1" style="vertical-align: middle">Day 5</th>
            <th rowspan="1" style="vertical-align: middle">Day 6</th>
            <th rowspan="1" style="vertical-align: middle">Day 7</th>
            <th rowspan="1" style="vertical-align: middle">Day 8</th>
            <th rowspan="1" style="vertical-align: middle">Day 9</th>
            <th rowspan="1" style="vertical-align: middle">Day 10</th>
            <th rowspan="1" style="vertical-align: middle">Day 11</th>
            <th rowspan="1" style="vertical-align: middle">Day 12</th>
            <th rowspan="1" style="vertical-align: middle">Day 13</th>
            <th rowspan="1" style="vertical-align: middle">Day 14</th>
            <th rowspan="1" style="vertical-align: middle">Day 15</th>
            <th rowspan="1" style="vertical-align: middle">Day 16</th>
            <th rowspan="1" style="vertical-align: middle">Day 17</th>
            <th rowspan="1" style="vertical-align: middle">Day 18</th>
            <th rowspan="1" style="vertical-align: middle">Day 19</th>
            <th rowspan="1" style="vertical-align: middle">Day 20</th>
            <th rowspan="1" style="vertical-align: middle">Day 21</th>
            <th rowspan="1" style="vertical-align: middle">Day 22</th>
            <th rowspan="1" style="vertical-align: middle">Day 23</th>
            <th rowspan="1" style="vertical-align: middle">Day 24</th>
            <th rowspan="1" style="vertical-align: middle">Day 25</th>
            <th rowspan="1" style="vertical-align: middle">Day 26</th>
            <th rowspan="1" style="vertical-align: middle">Day 27</th>
            <th rowspan="1" style="vertical-align: middle">Day 28</th>
            <th rowspan="1" style="vertical-align: middle">Day 29</th>
            <th rowspan="1" style="vertical-align: middle">Day 30</th>
            <th rowspan="1" style="vertical-align: middle">Day 31</th>
            <th rowspan="1" style="vertical-align: middle">N</th>
            <th rowspan="1" style="vertical-align: middle">N+1</th>
            <th rowspan="1" style="vertical-align: middle">N+2</th>
            <th rowspan="1" style="vertical-align: middle">N+3</th>
            <th rowspan="1" style="vertical-align: middle">N+4</th>
            <th rowspan="1" style="vertical-align: middle">N+5</th>
            <th rowspan="1" style="vertical-align: middle">N+6</th>
            <th rowspan="1" style="vertical-align: middle">Create By</th>
            <th rowspan="1" style="vertical-align: middle">Create Date</th>
            <th rowspan="1" style="vertical-align: middle">Create Time</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $session = $this->session->all_userdata();
        if ($data_wo == 'NULL') {
        } else {
            $r = 1;
            foreach ($data_wo as $isi) {
                echo "<tr >";
                echo "<td style=text-align:center;>$r</td>";
                echo "<td style=text-align:center;>$isi->CHR_PART_NO_CUST</td>";
                echo "<td style=text-align:center;>$isi->CHR_PART_NO</td>";
                echo "<td style=text-align:left>$isi->CHR_PART_NAME</td>";
                echo "<td style=text-align:center;>$isi->CHR_CUST_CODE</td>";
                // echo "<td style=text-align:center;>$isi->CHR_MONTH</td>";
                // echo "<td style=text-align:center;>$isi->CHR_VERSION</td>";
                echo "<td style=text-align:center;>$isi->INT_DAY_01</td>";
                echo "<td style=text-align:center;>$isi->INT_DAY_02</td>";
                echo "<td style=text-align:center;>$isi->INT_DAY_03</td>";
                echo "<td style=text-align:center;>$isi->INT_DAY_04</td>";
                echo "<td style=text-align:center;>$isi->INT_DAY_05</td>";
                echo "<td style=text-align:center;>$isi->INT_DAY_06</td>";
                echo "<td style=text-align:center;>$isi->INT_DAY_07</td>";
                echo "<td style=text-align:center;>$isi->INT_DAY_08</td>";
                echo "<td style=text-align:center;>$isi->INT_DAY_09</td>";
                echo "<td style=text-align:center;>$isi->INT_DAY_10</td>";
                echo "<td style=text-align:center;>$isi->INT_DAY_11</td>";
                echo "<td style=text-align:center;>$isi->INT_DAY_12</td>";
                echo "<td style=text-align:center;>$isi->INT_DAY_13</td>";
                echo "<td style=text-align:center;>$isi->INT_DAY_14</td>";
                echo "<td style=text-align:center;>$isi->INT_DAY_15</td>";
                echo "<td style=text-align:center;>$isi->INT_DAY_16</td>";
                echo "<td style=text-align:center;>$isi->INT_DAY_17</td>";
                echo "<td style=text-align:center;>$isi->INT_DAY_18</td>";
                echo "<td style=text-align:center;>$isi->INT_DAY_19</td>";
                echo "<td style=text-align:center;>$isi->INT_DAY_20</td>";
                echo "<td style=text-align:center;>$isi->INT_DAY_21</td>";
                echo "<td style=text-align:center;>$isi->INT_DAY_22</td>";
                echo "<td style=text-align:center;>$isi->INT_DAY_23</td>";
                echo "<td style=text-align:center;>$isi->INT_DAY_24</td>";
                echo "<td style=text-align:center;>$isi->INT_DAY_25</td>";
                echo "<td style=text-align:center;>$isi->INT_DAY_26</td>";
                echo "<td style=text-align:center;>$isi->INT_DAY_27</td>";
                echo "<td style=text-align:center;>$isi->INT_DAY_28</td>";
                echo "<td style=text-align:center;>$isi->INT_DAY_29</td>";
                echo "<td style=text-align:center;>$isi->INT_DAY_30</td>";
                echo "<td style=text-align:center;>$isi->INT_DAY_31</td>";
                echo "<td style=text-align:center;>$isi->INT_TOTAL</td>";
                echo "<td style=text-align:center;>$isi->INT_N1</td>";
                echo "<td style=text-align:center;>$isi->INT_N2</td>";
                echo "<td style=text-align:center;>$isi->INT_N3</td>";
                echo "<td style=text-align:center;>$isi->INT_N4</td>";
                echo "<td style=text-align:center;>$isi->INT_N5</td>";
                echo "<td style=text-align:center;>$isi->INT_N6</td>";
                echo "<td style=text-align:center;>$isi->CHR_CREATE_BY</td>";
                echo "<td style=text-align:center;>$isi->CHR_CREATE_DATE</td>";
                echo "<td style=text-align:center;>$isi->CHR_CREATE_TIME</td>";
        ?>
                </tr>
        <?php
                $r++;
            }
        }
        ?>
    </tbody>
</table>

<script src="<?php echo base_url('assets/js/jquery-1.12.3.js') ?>"></script>
<script src="<?php echo base_url('assets/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?php echo base_url('assets/js/dataTables.fixedColumns.min.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/css/fixedColumns.dataTables.min.css'); ?>">
<script>
    $(document).ready(function() {
        var table = $('#example2').DataTable({
            scrollY: "390px",
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
                leftColumns: 5
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