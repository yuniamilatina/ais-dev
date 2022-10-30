<div class="grid">
    <div class="grid-header">
        <i class="fa fa-calendar"></i>
        <span class="grid-title"><strong><?php echo $data_detail->CHR_DEPT_DESC ?></strong> Detail</span>
        <div class="pull-right grid-tools">
            <a data-widget="remove" title="Remove"><i class="fa fa-times"></i></a>
        </div>

    </div>
    <div class="grid-body">

        <h4><strong><?php echo $data_detail->CHR_DEPT_DESC ?></strong>'s Pure Expenses </h4>
        <?php
        $co = count($dept_expense);

        if ($co != 0) {
            echo '<table id="dataTables1" class="table table-condensed table-hover display" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Code</th>
                    <th>Category</th>
                </tr>
            </thead>
            <tbody>';
            ?>

            <?php
            $i = 1;
            foreach ($dept_expense as $isi) {
                echo "<tr class='gradeX'>";
                echo "<td>$i</td>";
                echo "<td>".trim($isi->CHR_BUDGET_CATEGORY)."</td>";
                echo "<td>".trim($isi->CHR_BUDGET_CATEGORY_DESC)."</td>";
                ?>
                </tr>
                <?php
                $i++;
            }
            echo '</tbody>
                    </table>';
        } else {
            echo 'No Data Recorded';
        }
        ?>
        <h4><strong><?php echo $data_detail->CHR_DEPT_DESC ?></strong>'s Sub Expenses </h4>
        <?php
        $co = count($dept_subexpense);

        if ($co != 0) {
            echo '<table id="dataTables1" class="table table-condensed table-hover display" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Code</th>
                    <th>Type</th>
                </tr>
            </thead>
            <tbody>';
            ?>

            <?php
            $i = 1;
            foreach ($dept_subexpense as $isi) {
                echo "<tr class='gradeX'>";
                echo "<td>$i</td>";
                echo "<td>".trim($isi->CHR_BUDGET_TYPE)."</td>";
                echo "<td>".trim($isi->CHR_BUDGET_TYPE_DESC)."</td>";
                ?>
                </tr>
                <?php
                $i++;
            }
            echo '</tbody>
                    </table>';
        } else {
            echo 'No Data Recorded';
        }
        ?>
    </div>
</div>