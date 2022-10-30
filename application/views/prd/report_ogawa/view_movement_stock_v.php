                    <div class="grid-body">
                        <table id="dataTables2" class="table table-condensed table-striped table-hover display" cellspacing="0" width="100%" style="font-size:11px;">
                            <thead>
                                <tr>
                                    <th style="text-align:center;">No</th>
                                    <th style="text-align:center;">Part No</th>
                                    <th style="text-align:center;">Back No</th>
                                    <th style="text-align:center;">Part Name</th>
                                    <th style="text-align:center;">Sloc</th>
                                    <th style="text-align:center;">Total Qty</th>
                                    <th style="text-align:center;">Unit</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                foreach ($data as $val) {
                                    echo "<tr align='center'>";
                                    echo "<td>" . $no . "</td>";
                                    echo "<td>" . $val->CHR_PART_NO . "</td>";
                                    echo "<td>" . $val->CHR_BACK_NO . "</td>";
                                    echo "<td>" . $val->CHR_PART_NAME . "</td>";
                                    echo "<td>" . $val->CHR_SLOC . "</td>";
                                    echo "<td>" . $val->INT_PART_QTY . "</td>";
                                    echo "<td>" . $val->CHR_PART_UOM . "</td>";                                    
                                    echo "</tr>";
                                    $no++;
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>

                    <script>

                    $(document).ready(function() {
                        $('#dataTables2').DataTable({
                            scrollX: true,
                            lengthMenu: [
                                [10, 25, 50, -1],
                                [10, 25, 50, "All"]
                            ]
                        });
                    });

                    </script>