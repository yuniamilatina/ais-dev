<div class="grid"><div class="grid-header">
        <i class="fa fa-calendar"></i>
        <span class="grid-title"><strong>PROJECT</strong> Detail</span>
        <div class="pull-right grid-tools">
            <a data-widget="remove" title="Remove"><i class="fa fa-times"></i></a>
        </div>

    </div>
    <div class="grid-body">
        <table class="table table-striped table-bordered table-condensed display" cellspacing="0" width="100%">
            <tr><td>Project Code</td><td><?php echo $project->CHR_PROJECT; ?></td></tr>
            <tr><td>Project Name</td><td><?php echo $project->CHR_PROJECT_DESC; ?></td></tr>
            <tr><td>Customer</td><td><?php echo $project->CHR_CUSTOMER; ?></td></tr>
            <tr><td>New Project</td><td><?php if($project->BIT_FLG_NEW_PROJECT == 1){ echo "Yes"; } else { echo "No"; }; ?></td></tr>
            <tr><td>Masspro</td><td><?php if($project->CHR_MASSPRO_DATE != NULL){ echo strtoupper(date("F", mktime(null, null, null, substr($project->CHR_MASSPRO_DATE, 4, 2)))).' '.substr($project->CHR_MASSPRO_DATE, 0, 4); } ?></td></tr>

        </table>
        <h4><strong><?php echo $project->CHR_PROJECT ?></strong>'s Product </h4>
        <?php
        $co = count($project_product);

        if ($co != 0) {
            echo '<table id="dataTables1" class="table table-striped table-condensed table-bordered display" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Code</th>
                    <th>Product</th>
                    

                </tr>
            </thead>
            <tbody>';
            ?>

            <?php
            $i = 1;


            foreach ($project_product as $isi) {
                echo "<tr class='gradeX'>";
                echo "<td>$i</td>";
                echo "<td>$isi->CHR_PRODUCT</td>";
                echo "<td>$isi->CHR_PRODUCT_DESC</td>";
                ?>

                </tr>
                <?php
                $i++;
            }
            echo '</tbody>
                    </table>';
        } else {
            echo 'No data recorded.';
        }
        ?>
    </div>
</div>