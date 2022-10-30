<aside class="right-side">

    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/'); ?>"><span>Home</span></a></li>
            <li><a href=""><strong>E Faktur</strong></a></li>
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
                        <i class="fa fa-wrench"></i>
                        <span class="grid-title"><strong>EXPORT DATA E-FAKTUR KELUARAN</strong></span>
                    </div>

                    <div class="grid-body">
                        <form action="" method="POST">
                            <table>
                                <tr>
                                    <td width="100">No Invoice</td>
                                    <td>:</td>
                                    <td>
                                        <input type="text" value="" name="INV_NO_LOW">
                                    </td>
                                    <td> to </td>
                                    <td>
                                        <input type="text" value="" name="INV_NO_HIGH">
                                    </td>
                                </tr>
                                <tr>
                                    <td width="100">Tipe File</td>
                                    <td>:</td>
                                    <td>
                                        <input type="radio" name="tipe" value="csv" checked> csv
                                        <input type="radio" name="tipe" value="xls"> xls
                                    </td>
                                </tr>
                                <tr>
                                    <td width="100">Tipe Faktur</td>
                                    <td>:</td>
                                    <td>
                                        <input type="radio" name="tipe_faktur" value="biasa" checked> Biasa
                                        <input type="radio" name="tipe_faktur" value="pengganti"> Pengganti
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td>
                                        <input type="submit" name="btn_export" value="Export to Excel" onClick="">
                                    </td>
                                </tr>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </section>
</aside>