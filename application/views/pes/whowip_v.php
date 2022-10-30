<?php

?>
<aside class="right-side">

    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/'); ?>"><span>Home</span></a></li>
            <li><a href="<?php echo base_url('index.php/pes/prodentry_c/'); ?>">Production Entry System</a></li>
            <li><a href="<?php echo base_url('index.php/pes/tranrmwho_c/'); ?>">Transaksi Raw Material Execution</a></li>
            <li><a href=""><strong>Transaksi RM WHO WIP</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-wrench"></i>
                        <span class="grid-title"><strong>TRANSAKSI RM</strong> WHO WIP</span> 
<!-- begin tag aside  -->
                        <aside> 
                        <div style="width:75%; float: left" >
                            <div class="col-sm-12" style="width:75%; float: center">
                            <div class="panel panel-default">
                                <div class="panel-heading">SELAMAT DATANG SILAHKAN SCAN BARANG YANG INGIN ANDA AMBIL</div>
                            </div>
                            <p>Scan Barcode "FINISH" untuk menyelesaikan transaksi pengambilan barang</p> <br>
                            <form class="form-inline" name="form" method="post" action="<?= base_url() ?>index.php/pes/tranrmwho_c/whowip">
                            <div class ="form-group txt" style="text-align: center;">
                                <input autocomplete="off" type="text" name="box" id="box" placeholder="0 BOX" style="text-align:center" disabled>
                            </div>
                            <div class ="form-group txt" style="text-align: center;">
                                <input autocomplete="off" type="text" required="required" name="barcode" id="barcode" placeholder="Scan Barcode" style="text-align:center" onchange="movefield()" autofocus >
                            </div>
                            <div class ="form-group" style="text-align: center;">
                                <input autocomplete="on" type="text" name="qtybox" id="qtybox" placeholder="Quantity Box" style="text-align:center" onchange="submit()"  >
                            </div>
                            </form> <br>                
<!-- begin table content -->
                        <div class="table-content">
                            <div style="width:100%;margin-left: auto;margin-right: auto;margin-top: 5px;">
                            <table class="display" cellspacing="0" width="100%">
                            <thead>
                                <tr>    
                                    <th>No</th>
                                    <th>Part Number</th>
                                    <th>Part Name</th>
                                    <th>Back Number</th>
                                    <th>Qty/Box</th>
                                    <th>Quantity Box</th>
                                </tr>
                            </thead> 
                            <<tbody>
                                <tr>
                                    <td></td>
                                </tr>
                            </tbody>
                            </table>
                            </div>
                        </div>
<!-- end class table-content -->
                        </div>  
                        </aside> 
<!-- end tag aside  -->
                	</div>
                </div>
            </div>
        </div>
    </section>
</aside>

<?php
function test_input($data) {
$data = trim($data);
$data = stripslashes($data);
$data = htmlspecialchars($data);
return $data;
    }
?>

<script type="text/javascript">
    function submit () {
         var key;
         if (window.event) key = window.event.key;
         else if (e) key = e.which; {
            if (key == "13") {
                document.form.submit();
            }
         }
    }
    function movefield() {
         document.getElementById('qtybox').focus();
    }

</script>

