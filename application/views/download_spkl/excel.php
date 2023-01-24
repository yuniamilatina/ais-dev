<?php
    header ("Cache-Control: no-cache, must-revalidate");
    header ("Pragma: no-cache");
    header ("Content-type: application/x-msexcel");
    header ("Content-type: application/octet-stream");
    header ("Content-Disposition: attachment; filename=Name_file.xls");
?>

<?php
if ($data->num_rows() >0) {
    foreach ($data->result() as $row ){
        ?>
        <tr>
            <td> <?php echo $row-> ; ?></td>
            <td> <?php echo $row->; ?></td>
            <td> <?php echo $row->; ?></td>
            <td> <?php echo $row->; ?></td>
            <td> <?php echo $row->; ?></td>
            <td> <?php echo $row-> ; ?></td>
            <td> <?php echo $row-> ; ?></td>
            <td> <?php echo $row->; ?></td>
            <td> <?php echo $row-> remark; ?></td>
            
    }
}
