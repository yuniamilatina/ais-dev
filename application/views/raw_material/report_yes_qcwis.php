<?php if ($data_yes == false) { ?>
    <table width=100% id='filterdiagram'>
        <td> No data available in diagram</td>
    </table>
<?php } else { ?>
    <div class="grid-body" style="height: 400px; width: 100%;">
        <table id="dataTables1" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th style="text-align:center;">No</th>
                    <th style="text-align:center;">Prod No</th>
                    <th style="text-align:center;">Sampling</th>
                    <th style="text-align:center;">Date</th>
                    <th style="text-align:center;">Result</th>
                </tr>
            </thead>

            <tbody>
                <?php
                $r = 1;
                foreach ($data_yes as $isi) {
                    echo "<tr class='gradeX'>";
                    echo "<td style='text-align:center;'>$r</td>";
                    echo "<td style='text-align:center;'>$isi->CHR_LOT_NOMOR</td>";
                    echo "<td style='text-align:center;'>$isi->CHR_STRATEGY</td>";
                ?>
                    <td style="text-align:center;">
                        <?php echo date("d-M-Y", strtotime($isi->CHR_CREATED_DATE)) ?>
                    </td>
                    <?php if ($isi->CHR_RESULT = 'YES') { ?>
                        <td style="text-align:center;background-color:green;color: white;">
                            YES
                        </td>
                    <?php } else { ?>
                        <td style="text-align:center;background-color:red">
                            NO
                        </td>
                    <?php } ?>
                    </tr>
                <?php
                    $r++;
                }
                ?>
            </tbody>
        </table>

    </div>
<?php } ?>