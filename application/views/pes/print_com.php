<!DOCTYPE html>
<html>
<head>
<style>
table, th, td {
    border: 1px solid black;
    border-collapse: collapse;
}
th, td {
    padding: 2px;
}
th {
    text-align: left;
}
</style>
</head>
<body>
    <h1>Repair List</h1>
                            <table id="dataTables1" cellspacing="0" width="50%" style="margin-top: 50px; margin-left: 30px; ">
                                        <thead>
                                            <tr>
                                                <th>NO</th>
                                                <th>Component Part No</th>
                                                <th>Description</th>

                                                <th>Qty/PC</th>
                                                <th>Qty</th>
                                                <th>Uom</th>

                                                <th>Oke</th>
                                                <th> Repair</th>
                                                <th>NG</th>

                                                <th>Area</th>
                                            </tr>
                                        </thead>
                                
                                        <tbody>
                                       
                                          <?php 
                                          foreach ($outprint as $show) {
                                           ?>
                                            <tr>
                                                <td><?php echo $show['no'];?></td>
                                                <td><?php echo $show['IDNRK']; ?></td>
                                                <td><?php echo $show['OJTXP']; ?></td>

                                                <td><?php echo $show['MENGE'];?></td>
                                                <td><?php echo $show['qty'];?></td>
                                                <td><?php echo $show['MMEIN'];?></td>

                                                <td><?php echo $show['oke'];?></td>
                                                <td><?php echo $show['repair'];?></td>
                                                <td><?php echo $show['NG'];?></td>
                                                <td><?php echo $show['sloc'];?></td>

                                                
                                            </tr>
                                           <?php }?>

                                        </tbody>
                                    </table>

</body>
</html>