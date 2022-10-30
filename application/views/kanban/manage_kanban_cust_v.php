<style type="text/css">
    th, td { white-space: nowrap; }
    div.dataTables_wrapper {
        width: 100%;
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
    .ddl{
        width: 100px;
        height: 30px;
    }
    .ddl2{
        width: 180px;
        height: 30px;
    }
</style>

<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/"') ?>"><span>Home</span></a></li>
            <li><a href=#"><span><strong>View Customer Number</strong></span></a></li>
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
                        <i class="fa fa-sitemap"></i>
                        <span class="grid-title"><strong>VIEW CUSTOMER NUMBER</strong></span>
                        <div class="pull-right">
                        </div>
                    </div>
                    <div class="grid-body">
                        <div id="table-luar">
                            <table id="dataTables1" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th style="text-align: left">Part Number</th>
                                        <th style="text-align: center">Customer Number</th>
                                        <th style="text-align: center">Customer</th>
                                        <th style="width: 100%">Part Name</th>
                                        <th>Back Number</th>
                                        <th>Type Kanban</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    foreach ($data as $isi) {
                                        echo "<tr class='gradeX'>";
                                        echo "<td>$i</td>";
                                        echo "<td style='text-align: left'>$isi->CHR_PART_NO</td>";
                                        echo "<td style='text-align: left'>$isi->CHR_CUS_PART_NO</td>";
                                        echo "<td style='text-align: left'>$isi->CHR_CUST_NAME</td>";
                                        echo "<td style='width: 100%'>$isi->CHR_PART_NAME</td>";
                                        echo "<td>$isi->CHR_BACK_NO</td>";
                                        echo "<td>$isi->TYPE_KANBAN</td>";
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


