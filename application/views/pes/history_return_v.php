<?php
session_start();
?>
// <script type="text/javascript">
// $(document).ready(function () {
//     $("#pilih").change(function () {
//         var x = $(this).val();
//         if (x == "WP01") {
//             $(this).attr("disabled", true);
//             $("#backno").attr("readonly", false); 
//             $("#quantity").attr("readonly", false);
//             document.getElementById('backno').focus(); 
//         }
//         else if (x == "PP01") {
//             $(this).attr("disabled", true);
//             $("#backno").attr("readonly", false); 
//             $("#quantity").attr("readonly", false);
//             document.getElementById('backno').focus();
//         }
//         else if (x == "PP02") {
//             $(this).attr("disabled", true);
//             $("#backno").attr("readonly", false); 
//             $("#quantity").attr("readonly", false);
//         }
//         else if (x == "PP03") {
//             $(this).attr("disabled", true);
//             $("#backno").attr("readonly", false); 
//             $("#quantity").attr("readonly", false);
//         }
//     });
//     $("#add").click(function () {
//         $.ajax({
//                 url: "<?= base_url() ?>index.php/pes/stock_transfer_c/getpartno",
//                 data: {backno: $('#backno').val()},type: 'POST',
//                 success: function(data) {
//                     // alert(data);
//                     $("#partno").val(data);
//                 }
//             });
//         $.ajax({
//                 url: "<?= base_url() ?>index.php/pes/stock_transfer_c/getbackno",
//                 data: {backno: $('#backno').val()},type: 'POST',
//                 success: function(data) {
//                     // alert(data);
//                     $("#bno").val(data);
//                 }
//             });
//         $.ajax({
//                 url: "<?= base_url() ?>index.php/pes/stock_transfer_c/getpartname",
//                 data: {backno: $('#backno').val()},type: 'POST',
//                 success: function(data) {
//                     // alert(data);
//                     $("#pname").val(data);
//                 }
//             });
//         $.ajax({
//                 url: "<?= base_url() ?>index.php/pes/stock_transfer_c/getqty",
//                 data: {quantity: $('#quantity').val()},type: 'POST',
//                 success: function(data) {
//                     // alert(data);
//                     $("#qty").val(data);
//                 }
//             });
//         document.getElementById('backno').value = "";
//         document.getElementById('quantity').value = "";
//         var table = document.getElementById("dataTable");
//         var rowCount = table.rows.length;
//         var newinput = rowCount - 1;
//         var row = table.insertRow(rowCount);
//         var colCount = table.rows[0].cells.length;  
//         for(var i=0; i<colCount; i++) {
//             var newcell = row.insertCell(i);
//             newcell.innerHTML = table.rows[newinput].cells[i].innerHTML;
            
//         }
//     });    
// });
// // end document ready
// </script>
<aside class="right-side">

    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/'); ?>"><span>Home</span></a></li>
            <li><a href="<?php echo base_url('index.php/pes/prodentry_c/'); ?>">Stock Transfer System</a></li>
            <li><a href="<?php echo base_url('index.php/pes/stock_transfer_c/'); ?>">Stock Transfer Execution</a></li>
            <li><a href=""><strong>History Stock Transfer</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12 text-center">
                <div class="grid">
                    <div class="grid-header">
                        <div class="panel panel-default">
                            <div class="panel-heading">SILAHKAN MASUKKAN TANGGAL</div>
                        </div>  
                    </div>
                    <div class="grid-body">
                        <div class="col-sm-12" style="width:75%; float: center">
                            <div class="row" style="margin-bottom:30px">
                            <form class="form-inline" method="post" action="">
                                <div class="col-sm-2 col-sm-offset-8 box" style="width:auto">
                                    <a href="<?= base_url() ?>index.php/pes/stock_transfer_c" class="btn" style="background-color:#66ccff;width:100px;height:30px" >EXIT</a>
                                </div>
                            </div>
                            <div class="row">
                                <form method="post" action="">
                                <div class="col-sm-2" style="width:auto">
                                    <label>Tanggal</label>
                                </div>
                                <div class="col-sm-3" style="margin-right:20px">
                                    <input type="text" name="chr_date_from" class="form-control" id="datepicker" placeholder="" value="<?php echo date('m/d/Y')?>">
                                </div>
                                <div class="col-sm-3">
                                    <input type="text" name="chr_date_to" class="form-control" id="datepicker" placeholder="" value="<?php echo date('m/d/Y')?>">
                                </div>
                                <div class="col-sm-2" style="width:auto">
                                    <input type="submit" id="execute" name="execute" value="EXECUTE">
                                </div>
                            </div><br> 
                        </div>
                        <!-- begin table content -->
                        <div class="table-content">
                            <div style="width:100%;margin-left: auto;margin-right: auto;margin-top: 5px;border">
                            <table class="table table-bordered" id="dataTable" cellspacing="0" width="100%">
                            <thead>
                                <tr>    
                                    <th style="width:20px">No</th>
                                    <th style="width:100px">Tanggal</th>
                                    <th style="width:100px">Back Number</th>
                                    <th style="width:100px">Part Number</th>
                                    <th style="width:200px">Part Name</th>
                                    <th style="width:50px">Sloc From</th>
                                    <th style="width:50px">Sloc To</th>
                                    <th style="width:50px">Quantity</th>
                                </tr>
                            </thead> 
                            <tbody>
                                <?php
                                $no = 1;
                                for ($i=0; $i < $q ; $i++) { ?>
                                <tr>
                                <td><?php echo $no; ?></td>
                                <td><?php echo $tanggal[$i]; ?></td>
                                <td><?php echo $backno[$i]; ?></td>
                                <td><?php echo $partno[$i]; ?></td>
                                <td><?php echo $pname[$i]; ?></td>
                                <td><?php echo $slocfrom[$i]; ?></td>
                                <td><?php echo $slocto[$i]; ?></td>
                                <td><?php echo $qty[$i]; ?></td>
                                </tr>
                                <?php
                                $no++;
                                }
                                ?>
                            </tbody>
                            </table>
                            </form>
                            </div>
                        </div>
                         </form>
                        <!-- end class table-content -->
                    </div>

                </div>  
            </div>
        </div>
    </section>
</aside>
<script type="text/javascript">

    // function movefield() {
    //      document.getElementById('qty').focus();
    // }
</script>

