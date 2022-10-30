<?php
$start_dt  = substr($start_dt, 6, 2) . " - " . substr($start_dt, 4, 2) . " - " . substr($start_dt, 0, 4);
$finish_dt  = substr($finish_dt, 6, 2) . " - " . substr($finish_dt, 4, 2) . " - " . substr($finish_dt, 0, 4);
?>

<html>

<head>
    <title>Temp Part PT Aisin Indonesia</title>
    <style>
        table,
        th,
        tr,
        td {
            border: 1.5px solid black;
            border-collapse: collapse;
            font-size: 10px;
            font-family: "Courier New", Courier, monospace;
        }

        .border {
            border: 1px solid black;
            border-collapse: collapse;
        }
    </style>
</head>

<body>
    <div class="test">
        <table width="100%" style="border: none;">
            <tr height="">
                <td style="font-size: 40px;font-weight: bold;border: none;text-align: center"><span style="margin-left: 4px;">Temporary Part Sheet</span></td>

            </tr>
        </table>

        <table style="margin-top: 40px;" border="0" cellspacing="0" cellpadding="0">
            <tr style="border: none;">
                <td style="font-size: 24px;">Temp ID </td>
                <td style="font-size: 24px;">: </td>
                <td style="font-size: 24px;"><?php echo $temp_id; ?></td>
            </tr>
            <tr>
                <td style="font-size: 24px;width: 25%">PIC </td>
                <td style="font-size: 24px;width: 5%">: </td>
                <td style="font-size: 24px;width: 70%"><?php echo $pic; ?></td>
            </tr>
            <tr>
                <td style="font-size: 24px;">Dept </td>
                <td style="font-size: 24px;">: </td>
                <td style="font-size: 24px;"><?php echo $dept; ?></td>
            </tr>
            <tr>
                <td style="font-size: 24px;">Deskripsi </td>
                <td style="font-size: 24px;">: </td>
                <td style="font-size: 24px;"><?php echo $desc; ?></td>
            </tr>
            <tr>
                <td style="font-size: 24px;">Start Date </td>
                <td style="font-size: 24px;">: </td>
                <td style="font-size: 24px;"><?php echo $start_dt; ?></td>
            </tr>
            <tr>
                <td style="font-size: 24px;">Finish Date </td>
                <td style="font-size: 24px;">: </td>
                <td style="font-size: 24px;"><?php echo $finish_dt; ?></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td><img src="assets/barcode/<?php echo $temp_id ?>.png" width="290" height="250"></td>
            </tr>
        </table><br />

</body>

</html>