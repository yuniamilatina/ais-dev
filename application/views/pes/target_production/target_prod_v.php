<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/tablemaster.js" ></script>
<style type="text/css">
    .vcenter {
        vertical-align: middle !important;
        text-align: center !important;
        white-space: nowrap !important;
    }

    .vleft{
        vertical-align: middle !important;
        text-align: left !important;
        white-space: nowrap !important;
    }

    .vright{
        vertical-align: middle !important;
        //text-align: right; !important;
        white-space: nowrap !important;
        font-weight:bold;
    }

    .input-change{
        text-align: right;
        height: 24px !important;
        padding: 4px;
        font-weight:bold;
    }

    .app-check{
        height: 15px !important;
    }

</style>
<script type="text/javascript">
    $(document).ready(function () {
        $('#txt_line').autocomplete({
            source: "<?php echo site_url('pes/promasdat_c/searchWoTP'); ?>",
            minLength: 1,
        });
    });
</script>
<?php
if (!$targets) {
    echo "<script>";
    echo "alert(\"Data Tidak Ada\");";
    echo "window.location=window.location;";
    echo "</script>";
    exit();
}
?>

<aside class="right-side">

    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/'); ?>"><span>Home</span></a></li>
            <li><a href="<?php echo base_url('index.php/pes/prodentry_c/'); ?>">Production Entry System</a></li>
            <li><a href="<?php echo base_url('index.php/pes/promasdat_c/'); ?>">Master Data Production Execution</a></li>
            <li><a href=""><strong>Target Production</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-wrench"></i>
                        <span class="grid-title"><strong>MASTER </strong>TARGET PRODUCTION</span>        
                    </div>
                    <div class="grid-body"  > <!-- style="background-color: #94D1DC" -->
                        <div style="padding-bottom:25px; border:thin #000 !important;">
                            <form name="cari" id="cari" class="form-horizontal" method="POST" action="<?= base_url() ?>index.php/pes/promasdat_c/target_production">
                                <table width="100%" border="0">
                                    <tr>
                                        <td>Bulan</td>
                                        <td>: <input id="txt_bulan" name="txt_bulan" type="text" maxlength="2" onkeypress='return validateQty(event);'/></td>
                                        <td>Line</td>
                                        <td>: <input id="txt_line" name="txt_line" maxlength="6" type="text" /></td>
                                        <td>Tahun</td>
                                        <td>: <input id="txt_tahun" name="txt_tahun" type="text" maxlength="4" onkeypress='return validateQty(event);'/></td>     
                                        <td><button type="submit" class="btn btn-default" data-toggle="tooltip" data-placement="right" title="Go" style="height:30px"><i>GO</i></button></td>                       
                                    </tr>                                               
                                </table>
                            </form>
                        </div>
                        <form name="cart" id="cart" class="form-horizontal" method="POST" action="<?= base_url() ?>index.php/pes/promasdat_c/save_target_prod">
                            <table   >
                                <tr>
                                    <td align="left">
                                        <input type="button" id="add" value="Add New Row" onClick="addRow('dataTables1')" /> 
                                        <input type="button" id="del" value="Delete New Row" onClick="deleteRow('dataTables1', '<?php echo $tot_line; ?>')" />
                                        <input name="btn_save" id="simpan" type="button" value="Save" />
                                    </td>
                                </tr>
                            </table>
                            <div style="overflow-x:scroll; overflow-y: hidden" class="vcenter">
                                <table id="dataTables1" border="1" width="1500px">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th  style="text-align:center" width="100px">Bulan</th>
                                            <th  style="text-align:center">Tahun</th>
                                            <th  style="text-align:center">Line</th>
                                            <th  style="text-align:center">∑ CT (s)</th>
                                            <th  style="text-align:center">Man Hour/PC</th>
                                            <th  style="text-align:center">PC/Man Hour</th>
                                            <th  style="text-align:center">Plan MP (SWS)</th>
                                            <th  style="text-align:center">QTY/JAM (SWS)</th>
                                            <th >TARGET DELIVERY/DAY</th>
                                            <th >Plan Shift</th>
                                            <th >QTY/JAM (DELIVERY)</th>
                                            <th >QTY/JAM (GEDS)</th>
                                            <th >JML MP (GEDS)</th> 
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1;
                                        foreach ($targets as $target): ?>
                                            <tr>
                                                <td ></td>
                                                <td ><input type="text" class="form-control" readonly="readonly" name="INT_BULAN_OLD[]" 		value="<?php echo $target->INT_BULAN; ?>" /></td>
                                                <td ><input type="text" class="form-control" readonly="readonly" name="INT_TAHUN_OLD[]" 		value="<?php echo $target->INT_TAHUN; ?>" /> </td>
                                                <td ><input type="text" class="form-control" readonly="readonly" name="CHR_WORK_CENTER_OLD[]" 	value="<?php echo $target->CHR_WORK_CENTER; ?>" /></td>
                                                <td ><input type="text" class="form-control" name="INT_CT_OLD[]" 			value="<?php echo $target->INT_CT; ?>" 			onchange="calcTotals()" /></td>
                                                <td ><input type="text" class="form-control" name="CHR_MH_PC_OLD[]" 		value="<?php echo $target->CHR_MH_PC; ?>" 			/></td>
                                                <td ><input type="text" class="form-control" name="CHR_PC_MH_OLD[]" 		value="<?php echo $target->CHR_PC_MH; ?>" 			/></td>
                                                <td ><input type="text" class="form-control" name="INT_PLAN_MP1_OLD[]" 		value="<?php echo $target->INT_PLAN_MP1; ?>" 	onchange="calcTotals()"/></td>
                                                <td ><input type="text" class="form-control" name="INT_QTY_PER_JAM_OLD[]" 	value="<?php echo $target->INT_QTY_PER_JAM; ?>" /></td>
                                                <td ><input type="text" class="form-control" name="INT_TARGET_DEL_OLD[]" 	value="<?php echo $target->INT_TARGET_DEL; ?>" 	onchange="calcTotals()"/></td>
                                                <td ><input type="text" class="form-control" name="INT_PLAN_SHIFT_OLD[]" 	value="<?php echo $target->INT_PLAN_SHIFT; ?>" 	onchange="calcTotals()"/></td>
                                                <td ><input type="text" class="form-control" name="INT_QTY_PER_JAM_1_OLD[]" value="<?php echo $target->INT_QTY_PER_JAM_1; ?>" /></td>
                                                <td ><input type="text" class="form-control" name="INT_QTY_PER_JAM_2_OLD[]" value="<?php echo $target->INT_QTY_PER_JAM_2; ?>" /></td>
                                                <td ><input type="text" class="form-control" name="INT_PLAN_MP2_OLD[]" 		value="<?php echo $target->INT_PLAN_MP2; ?>" /></td>

                                            </tr>
                                            <?php $i++;
                                        endforeach; ?>
                                        <tr>
                                            <td ><input type="checkbox" name="chk[]" id="ckbx"/></td>
                                            <td ><input id="bulan_new" type="text" class="form-control" name="INT_BULAN_NEW[]"/ ></td>
                                            <td ><input type="text" class="form-control" name="INT_TAHUN_NEW[]"/> </td>
                                            <td ><input type="text" class="form-control" name="CHR_WORK_CENTER_NEW[]"/></td>
                                            <td ><input type="text" class="form-control" name="INT_CT_NEW[]" onchange="calcTotals1()"/></td>
                                            <td ><input type="text" class="form-control" name="CHR_MH_PC_NEW[]"/></td>
                                            <td ><input type="text" class="form-control" name="CHR_PC_MH_NEW[]"  /></td>
                                            <td ><input type="text" class="form-control" name="INT_PLAN_MP1_NEW[]" onchange="calcTotals1()"/></td>
                                            <td ><input type="text" class="form-control" name="INT_QTY_PER_JAM_NEW[]" /></td>
                                            <td ><input type="text" class="form-control" name="INT_TARGET_DEL_NEW[]"  onchange="calcTotals1()"/></td>
                                            <td ><input type="text" class="form-control" name="INT_PLAN_SHIFT_NEW[]" onchange="calcTotals1()"/></td>
                                            <td ><input type="text" class="form-control" name="INT_QTY_PER_JAM_1_NEW[]"  /></td>
                                            <td ><input type="text" class="form-control" name="INT_QTY_PER_JAM_2_NEW[]" /></td>
                                            <td ><input type="text" class="form-control" name="INT_PLAN_MP2_NEW[]" /></td>                            
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </form>

                    </div>                                                      
                </div>
            </div>
        </div>

    </section>
</aside>
<script type="text/javascript">
    $(document).ready(function () {
        $('#simpan').click(function () {
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/promasdat_c/save_target_prod',
                dataType: 'json',
                data: $('#cart').serialize(),
                success: function (data) {
                    console.log(data);
                    if (data == true) {
                        window.location = window.location;//location.reload();
                    } else {
                        alert(data);
                    }
                }
            });
        });
    });
</script>
<script>
    function calcTotals1() {
        var priceObj1;
        var row1 = 0;
        var jam = 3600;
        var perShift = 7.5;
        //var fav_count = document.getElementsByName('INT_BULAN_NEW[]');
        var priceObj1 = document.getElementsByName('INT_CT_NEW[]');
        var qtyObj1 = document.getElementsByName('INT_PLAN_MP1_NEW[]');
        var totalObj1 = document.getElementsByName('INT_QTY_PER_JAM_NEW[]');

        var tgtDeliveryObj1 = document.getElementsByName('INT_TARGET_DEL_NEW[]');
        var planShiftObj1 = document.getElementsByName('INT_PLAN_SHIFT_NEW[]');
        var qtyJamDelObj1 = document.getElementsByName('INT_QTY_PER_JAM_1_NEW[]');

        var mhPcObj1 = document.getElementsByName('CHR_MH_PC_NEW[]');
        var pcMhObj1 = document.getElementsByName('CHR_PC_MH_NEW[]');

        var lines = priceObj1.length;

        for (var i = 0; i < lines; i++)
        {
            mhPcObj1[i].value = jam + " / " + priceObj1[i].value;
            pcMhObj1[i].value = priceObj1[i].value + " / " + jam;

            if (priceObj1[i].value && qtyObj1[i].value)
            {
                totalObj1[i].value = Math.ceil((jam / (parseFloat(priceObj1[i].value)) * parseFloat(qtyObj1[i].value)));
            }
            else
            {
                totalObj1[i].value = '0';
            }

            //2ND CALC NEW

            if (tgtDeliveryObj1[i].value && planShiftObj1[i].value)
            {
                qtyJamDelObj1[i].value = Math.ceil(parseFloat(tgtDeliveryObj1[i].value) / (parseFloat(planShiftObj1[i].value) * perShift));
                //Math.ceil( qtyJamDelObj1.value);
            }
            else
            {
                qtyJamDelObj1.value = '0';
            }
            //row1++;
        }
        return;
    }
    function calcTotals() {
        var grandTotal = 0;
        var row = 0;
        var jam = 3600;
        var perShift = 7.5;
        while (document.forms['cart'].elements['INT_CT_OLD[]'][row])
        {
            priceObj = document.forms['cart'].elements['INT_CT_OLD[]'][row];
            qtyObj = document.forms['cart'].elements['INT_PLAN_MP1_OLD[]'][row];
            totalObj = document.forms['cart'].elements['INT_QTY_PER_JAM_OLD[]'][row];

            tgtDeliveryObj = document.forms['cart'].elements['INT_TARGET_DEL_OLD[]'][row];
            planShiftObj = document.forms['cart'].elements['INT_PLAN_SHIFT_OLD[]'][row];
            qtyJamDelObj = document.forms['cart'].elements['INT_QTY_PER_JAM_1_OLD[]'][row];

            var mhPcObj = document.forms['cart'].elements['CHR_MH_PC_OLD[]'][row];
            var pcMhObj = document.forms['cart'].elements['CHR_PC_MH_OLD[]'][row];

            mhPcObj.value = jam + " / " + priceObj.value;
            pcMhObj.value = priceObj.value + " / " + jam;
            //1ST CALC OLD
            if (isNaN(priceObj.value))
            {
                priceObj = '0';
            }
            if (isNaN(qtyObj.value))
            {
                qtyObj = '0';
            }

            if (priceObj.value && qtyObj.value)
            {
                totalObj.value = Math.ceil((jam / (parseFloat(priceObj.value)) * parseFloat(qtyObj.value)));
                //grandTotal = grandTotal + parseFloat(totalObj.value);
            }
            else
            {
                totalObj.value = '0';
            }

            //2ND CALC OLD
            if (isNaN(tgtDeliveryObj.value))
            {
                tgtDeliveryObj = '0';
            }
            if (isNaN(planShiftObj.value))
            {
                planShiftObj = '0';
            }
            if (tgtDeliveryObj.value && planShiftObj.value)
            {
                qtyJamDelObj.value = Math.ceil(parseFloat(tgtDeliveryObj.value) / (parseFloat(planShiftObj.value) * perShift));
            }
            else
            {
                qtyJamDelObj.value = '0';
            }
            if (isNaN(qtyJamDelObj.value))
            {
                planShiftObj = '0';
            }
            row++;
        }

        //document.getElementById('grand_total').value = grandTotal;
        return;
    }
    function validateQty(event) {
        var key = window.event ? event.keyCode : event.which;

        if (event.keyCode == 8 || event.keyCode == 46
                || event.keyCode == 37 || event.keyCode == 39) {
            return true;
        }
        else if (key < 48 || key > 57) {
            return false;
        }
        else
            return true;
    }
    ;
</script>