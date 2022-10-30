<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/"') ?>"><span>Home</span></a></li>
            <li> <a href="#"><strong>Table Documentation</strong></a></li>
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
                        <span class="grid-title"><strong>TABLE DOCUMENTATION</strong></span>
                        <div class="pull-right">
                        </div>
                    </div>
                    <div class="grid-body">
                        <table id="dataTables1" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Table Catalog</th>
                                    <th>Table Schema</th>
                                    <th>Table Name</th>
                                    <th>Action</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($data as $isi) {
                                    echo "<tr class='gradeX'>";
                                    echo "<td>$i</td>";
                                    echo "<td>$isi->TABLE_CATALOG</td>";
                                    echo "<td>$isi->TABLE_SCHEMA</td>";
                                    echo "<td>$isi->TABLE_NAME</td>";
                                    ?>
                                <td>
                                    <a href="<?php echo base_url('index.php/mis/table_c/print_documentation') . "/" . $isi->TABLE_CATALOG. "/" . $isi->TABLE_SCHEMA. "/" . $isi->TABLE_NAME; ?>" class="label label-primary" data-placement="top" data-toggle="tooltip" title="Print"><span class="fa fa-print"></span></a>
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

    </section>
</aside>


