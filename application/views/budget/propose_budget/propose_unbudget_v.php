<?php header("Content-type: text/html; charset=iso-8859-1"); ?>

<style>
    #filter { 
        border-spacing: 5px;
        border-collapse: separate;
    }
    
    #detail_request { 
        border-spacing: 5px;
        border-collapse: separate;
    }
    
    #budget_no {
        font-size: 13px;
        font-weight: bold;
        width: 220px;
        height: 30px;
    }
    
    #input_amo {
        font-size: 12px;
        font-weight: bold;
        max-width: 105px;
        max-height: 20px;
    }
    
    #input_qty {
        font-size: 12px;
        font-weight: bold;
        max-width: 40px;
        max-height: 20px;
    }
    
    #tot_amo {
        font-size: 13px;
        font-weight: bold;
        max-width: 150px;
        max-height: 30px;
    }
    
    #tot_qty {
        font-size: 13px;
        font-weight: bold;
        max-width: 50px;
        max-height: 30px;
    }

    #textarea {
        width: 350px;
        max-height: 50px;
    }
    
</style>
<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c') ?>"><span>Home</span></a></li>
            <li><a href="#"><strong>Propose Unbudget</strong></a></li>
        </ol>
    </section>
    <section class="content">
        <form method="post" action="<?php echo site_url("budget/propose_budget_c/save_propose_unbudget") ?>" class="form-horizontal" enctype="multipart/form-data" role="form">
        <div class="row">
            <div class="col-md-6">
                <div class="grid">                    
                    <div class="grid-header">
                        <i class="fa fa-th-large"></i>
                        <span class="grid-title"><strong>BUDGET HEADER</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <table width="100%" style=" border-spacing: 5px; border-collapse: separate;">
                            <input type="hidden" name="CHR_FISCAL_END" value="<?php echo $fiscal_end; ?>">
                            <input type="hidden" name="CHR_KODE_GROUP" value="<?php echo $kode_group; ?>">
                            <tr>
                                <td width="23%">Fiscal Year</td>
                                <td width="27%">
                                    <select name="CHR_FISCAL_START" class="form-control" id="tahun" onChange="document.location.href = this.options[this.selectedIndex].value;">
                                            <?php foreach ($all_fiscal as $data) { ?>
                                                <option value="<?php echo $data->CHR_FISCAL_YEAR_START; ?>"> <?php echo $data->CHR_FISCAL_YEAR; ?> </option>
                                            <?php } ?>
                                    </select>
                                </td>
                                <td width="23%"></td>
                                <td width="27%"></td>                                
                            </tr>                            
                            <tr>
                                <td width="23%">Department</td>
                                <td width="27%">
                                    <?php if($role == 5){ ?>
                                        <select disabled name="CHR_DEPT" class="form-control" id="dept" required>
                                    <?php } else { ?>
                                        <select name="CHR_DEPT" class="form-control" id="dept" onchange="getSection(value);getNoBudget();" required>
                                    <?php } ?>
                                            <option value=""></option>
                                            <?php foreach ($list_dept as $dept) { ?>                                                
                                                <option value="<?php echo $dept->CHR_KODE_DEPARTMENT; ?>"
                                                <?php
                                                    if($dept == $dept->CHR_KODE_DEPARTMENT){
                                                        echo " SELECTED";
                                                    }
                                                ?>> <?php echo $dept->CHR_KODE_DEPARTMENT; ?> </option>
                                            <?php } ?>
                                        </select>
                                </td> 
                                <td width="23%"></td>
                                <td width="27%"></td>
                            </tr>
                            <tr>
                                <td width="23%">Section</td>
                                <td colspan="2">
                                    <select name="CHR_SECTION" class="form-control" id="list_section" onchange="getNoBudget();" required>
                                        <!-- VALUE FROM JSON -->
                                    </select>
                                </td>
                                <td width="27%">
                            </tr>
                            <tr>
                                <td width="23%">Type Budget</td>
                                <td width="27%">
                                    <select name="CHR_TYPE_BUDGET" class="form-control" id="bgt_type" onchange="getCategory(value);getNoBudget();" required>
                                        <option value=""></option>
                                        <?php foreach ($all_bgt_type as $bgt) { ?>
                                            <option value="<?php echo $bgt->CHR_BUDGET_TYPE; ?>"> <?php echo $bgt->CHR_BUDGET_TYPE; ?> </option>
                                        <?php } ?>
                                    </select>
                                </td>
                                <td width="23%">
                                    <select name="CHR_CIP" class="form-control" id="cip" style="display:none;">
                                        <option value="0">Non CIP</option>
                                        <option value="1">CIP</option>
                                    </select>
                                </td>
                                <td width="27%"></td>
                            </tr>
                            <tr>
                                <td width="23%">Category</td>
                                <td colspan = "3">
                                    <select name="CHR_CATEGORY" class="form-control" id="list_category" required>
                                        <!-- VALUE FROM JSON -->
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td width="23%">Status</td>
                                <td width="27%">
                                    <select name="CHR_STATUS" class="form-control" id="status" required>
                                        <option value=""></option>
                                        <option value="0">Non Project</option>
                                        <option value="1">Project</option>
                                    </select>
                                </td>
                                <td colspan="2">
                                    <select name="CHR_PURPOSE" class="form-control" id="project" style="display:none;">
                                        <?php foreach ($list_project as $prj) { ?>
                                            <option value="<?php echo $prj->CHR_PROJECT_NUMBER; ?>"> <?php echo $prj->CHR_PROJECT_NUMBER . ' - ' . $prj->CHR_PROJECT_NAME; ?> </option>
                                        <?php } ?>
                                    </select>
                                    <select name="CHR_PROJECT" class="form-control" id="purpose" style="display:none;">
                                        <?php foreach ($list_purpose as $pur) { ?>
                                            <?php $purpose_desc = preg_replace('/[^A-Za-z0-9 ]/', '', $pur->CHR_DESC_PURPOSE_BUDGET) ?>
                                            <option value="<?php echo $pur->CHR_KODE_PURPOSE_BUDGET; ?>"> <?php echo $pur->CHR_KODE_PURPOSE_BUDGET . ' - ' . $purpose_desc; ?> </option>
                                        <?php } ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td width="23%"></td>
                                <td colspan="3"></td>
                            </tr>
                            <tr>
                                <td width="23%">Nomor Budget</td>
                                <td colspan="3">
                                    <input id="budget_no" name="CHR_NO_BUDGET" style="background-color: whitesmoke" readonly>
                                </td>
                            </tr>
                            <tr>
                                <td width="23%">Description</td>
                                <td colspan="3">
                                    <textarea id="textarea" name="CHR_DESC" required></textarea>
                                </td>                                
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="grid">                
                        <div class="grid-header">
                            <i class="fa fa-edit"></i>
                            <span class="grid-title">DETAIL OF <strong>REQUEST UNBUDGET</strong></span>
                            <div class="pull-right grid-tools">
                                <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                            </div>
                        </div>                        
                        <div class="grid-body">
                                <table width="100%" style=" border-spacing: 5px; border-collapse: separate;">
                                    <tr>
                                        <td width="33%" align="center" style="background-color: #002a80; color:white;">APR <?php echo $fiscal_start; ?></td>
                                        <td width="33%" align="center" style="background-color: #002a80; color:white;">MEI <?php echo $fiscal_start; ?></td>
                                        <td width="33%" align="center" style="background-color: #002a80; color:white;">JUN <?php echo $fiscal_start; ?></td>                                                                    
                                    </tr>
                                    <tr>
                                        <td width="33%" align="center">
                                            <input name="REQ_BGT_LIMBLN04" class="money" style="background-color: paleturquoise;" id="input_amo" value="0>" onfocus="if(this.value == '0'){ this.value = ''; }" onblur="if (this.value == '') { this.value = '0'; }">
                                            <input name="REQ_QTY_LIMBLN04" id="input_qty" class="qty" style="background-color: paleturquoise;" value="0" onfocus="if(this.value == '0'){ this.value = ''; }" onblur="if (this.value == '') { this.value = '0'; }">
                                        </td>
                                        <td width="33%" align="center">
                                            <input name="REQ_BGT_LIMBLN05" class="money" style="background-color: paleturquoise;" id="input_amo" value="0" onfocus="if(this.value == '0'){ this.value = ''; }" onblur="if (this.value == '') { this.value = '0'; }">
                                            <input name="REQ_QTY_LIMBLN05" id="input_qty" class="qty" style="background-color: paleturquoise;" value="0" onfocus="if(this.value == '0'){ this.value = ''; }" onblur="if (this.value == '') { this.value = '0'; }">
                                        </td>
                                        <td width="33%" align="center">
                                            <input name="REQ_BGT_LIMBLN06" class="money" style="background-color: paleturquoise;" id="input_amo" value="0" onfocus="if(this.value == '0'){ this.value = ''; }" onblur="if (this.value == '') { this.value = '0'; }">
                                            <input name="REQ_QTY_LIMBLN06" id="input_qty" class="qty" style="background-color: paleturquoise;" value="0" onfocus="if(this.value == '0'){ this.value = ''; }" onblur="if (this.value == '') { this.value = '0'; }">
                                        </td>                                                                   
                                    </tr>
                                    <tr><td>&nbsp;</td></tr>
                                    <tr>
                                        <td width="33%" align="center" style="background-color: #002a80; color:white;">JUL <?php echo $fiscal_start; ?></td>
                                        <td width="33%" align="center" style="background-color: #002a80; color:white;">AGU <?php echo $fiscal_start; ?></td>
                                        <td width="33%" align="center" style="background-color: #002a80; color:white;">SEP <?php echo $fiscal_start; ?></td>                                                                   
                                    </tr>
                                    <tr>
                                        <td width="33%" align="center">
                                            <input name="REQ_BGT_LIMBLN07" class="money" style="background-color: paleturquoise;" id="input_amo" value="0" onfocus="if(this.value == '0'){ this.value = ''; }" onblur="if (this.value == '') { this.value = '0'; }">
                                            <input name="REQ_QTY_LIMBLN07" id="input_qty" class="qty" style="background-color: paleturquoise;" value="0" onfocus="if(this.value == '0'){ this.value = ''; }" onblur="if (this.value == '') { this.value = '0'; }">
                                        </td> 
                                        <td width="33%" align="center">
                                            <input name="REQ_BGT_LIMBLN08" class="money" style="background-color: paleturquoise;" id="input_amo" value="0" onfocus="if(this.value == '0'){ this.value = ''; }" onblur="if (this.value == '') { this.value = '0'; }">
                                            <input name="REQ_QTY_LIMBLN08" id="input_qty" class="qty" style="background-color: paleturquoise;" value="0" onfocus="if(this.value == '0'){ this.value = ''; }" onblur="if (this.value == '') { this.value = '0'; }">
                                        </td>
                                        <td width="33%" align="center">
                                            <input name="REQ_BGT_LIMBLN09" class="money" style="background-color: paleturquoise;" id="input_amo" value="0" onfocus="if(this.value == '0'){ this.value = ''; }" onblur="if (this.value == '') { this.value = '0'; }">
                                            <input name="REQ_QTY_LIMBLN09" id="input_qty" class="qty" style="background-color: paleturquoise;" value="0" onfocus="if(this.value == '0'){ this.value = ''; }" onblur="if (this.value == '') { this.value = '0'; }">
                                        </td>                                                                                                    
                                    </tr>
                                    <tr><td>&nbsp;</td></tr>
                                    <tr>
                                        <td width="33%" align="center" style="background-color: #002a80; color:white;">OKT <?php echo $fiscal_start; ?></td>
                                        <td width="33%" align="center" style="background-color: #002a80; color:white;">NOV <?php echo $fiscal_start; ?></td> 
                                        <td width="33%" align="center" style="background-color: #002a80; color:white;">DES <?php echo $fiscal_start; ?></td>
                                    </tr>
                                    <tr>
                                        <td width="33%" align="center">
                                            <input name="REQ_BGT_LIMBLN10" class="money" style="background-color: paleturquoise;" id="input_amo" value="0" onfocus="if(this.value == '0'){ this.value = ''; }" onblur="if (this.value == '') { this.value = '0'; }">
                                            <input name="REQ_QTY_LIMBLN10" id="input_qty" class="qty" style="background-color: paleturquoise;" value="0" onfocus="if(this.value == '0'){ this.value = ''; }" onblur="if (this.value == '') { this.value = '0'; }">
                                        </td>
                                        <td width="33%" align="center">
                                            <input name="REQ_BGT_LIMBLN11" class="money" style="background-color: paleturquoise;" id="input_amo" value="0" onfocus="if(this.value == '0'){ this.value = ''; }" onblur="if (this.value == '') { this.value = '0'; }">
                                            <input name="REQ_QTY_LIMBLN11" id="input_qty" class="qty" style="background-color: paleturquoise;" value="0" onfocus="if(this.value == '0'){ this.value = ''; }" onblur="if (this.value == '') { this.value = '0'; }">
                                        </td>
                                        <td width="33%" align="center">
                                            <input name="REQ_BGT_LIMBLN12" class="money" style="background-color: paleturquoise;" id="input_amo" value="0" onfocus="if(this.value == '0'){ this.value = ''; }" onblur="if (this.value == '') { this.value = '0'; }">
                                            <input name="REQ_QTY_LIMBLN12" id="input_qty" class="qty" style="background-color: paleturquoise;" value="0" onfocus="if(this.value == '0'){ this.value = ''; }" onblur="if (this.value == '') { this.value = '0'; }">
                                        </td>
                                    </tr>
                                    <tr><td>&nbsp;</td></tr>
                                    <tr>
                                        <td width="33%" align="center" style="background-color: #002a80; color:white;">JAN <?php echo $fiscal_end; ?></td>
                                        <td width="33%" align="center" style="background-color: #002a80; color:white;">FEB <?php echo $fiscal_end; ?></td>
                                        <td width="33%" align="center" style="background-color: #002a80; color:white;">MAR <?php echo $fiscal_end; ?></td>

                                    </tr>
                                    <tr>                                
                                        <td width="33%" align="center">
                                            <input name="REQ_BGT_LIMBLN13" class="money" style="background-color: paleturquoise;" id="input_amo" value="0" onfocus="if(this.value == '0'){ this.value = ''; }" onblur="if (this.value == '') { this.value = '0'; }">
                                            <input name="REQ_QTY_LIMBLN13" id="input_qty" class="qty" style="background-color: paleturquoise;" value="0" onfocus="if(this.value == '0'){ this.value = ''; }" onblur="if (this.value == '') { this.value = '0'; }">
                                        </td>
                                        <td width="33%" align="center">
                                            <input name="REQ_BGT_LIMBLN14" class="money" style="background-color: paleturquoise;" id="input_amo" value="0" onfocus="if(this.value == '0'){ this.value = ''; }" onblur="if (this.value == '') { this.value = '0'; }">
                                            <input name="REQ_QTY_LIMBLN14" id="input_qty" class="qty" style="background-color: paleturquoise;" value="0" onfocus="if(this.value == '0'){ this.value = ''; }" onblur="if (this.value == '') { this.value = '0'; }">
                                        </td>
                                        <td width="33%" align="center">
                                            <input name="REQ_BGT_LIMBLN15" class="money" style="background-color: paleturquoise;" id="input_amo" value="0" onfocus="if(this.value == '0'){ this.value = ''; }" onblur="if (this.value == '') { this.value = '0'; }">
                                            <input name="REQ_QTY_LIMBLN15" id="input_qty" class="qty" style="background-color: paleturquoise;" value="0" onfocus="if(this.value == '0'){ this.value = ''; }" onblur="if (this.value == '') { this.value = '0'; }">
                                        </td>                                                                    
                                    </tr>
                                    <tr><td colspan="3">&nbsp;</td></tr>
                                    <tr>
                                        <td width="33%" align="center"></td>
                                        <td width="33%" align="center"></td>
                                        <td width="33%" align="center"></td>
                                    </tr>
                                    <tr>
                                        <td width="33%" align="right"><strong>Total Request &nbsp;&nbsp;&nbsp; Rp</strong></td>                                        
                                        <td width="33%">
                                            <input name="REQ_TOT_AMO" id="tot_amo" class="money_tot" value="0" style="background-color: paleturquoise; font-weight: bold" readonly>
                                        </td>                                        
                                        <td width="33%">
                                            <input name="REQ_TOT_QTY" id="tot_qty" class="qty_tot" value="0" style="background-color: paleturquoise; font-weight: bold" readonly>
                                        </td>
                                    </tr>
                                </table>
                            <div>&nbsp;</div>
                                <div>
                                    <table width="100%">
                                        <tr>
                                            <td width="40%"><strong>Keterangan </strong><i>(Harus diisi)</i></td>
                                            <td width="60%"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <textarea name="CHR_NOTES" id="note" value="" style="width:468px; height:70px; background-color: whitesmoke;" required></textarea>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div>
                                    <strong><i id="alert_1" style="color:red; display:none;"><span class="fa fa-exclamation-triangle"></span>  Amount Capex tidak boleh KURANG dari Rp 3.000.000,00</i></strong>
                                    <strong><i id="alert_2" style="color:red; display:none;"><span class="fa fa-exclamation-triangle"></span>  Amount Capex tidak boleh LEBIH dari satu (1) bulan</i></strong>
                                    <strong><i id="alert_3" style="color:red; display:none;"><span class="fa fa-exclamation-triangle"></span>  KETERANGAN harus minimal 5 huruf</i></strong>
                                </div>
                            <div align="right">
                                <input id="change_amo" name="CHR_FLG_CHANGE_AMOUNT" type="hidden" value="0">
                                <input id="reschedule" name="CHR_FLG_RESCHEDULE" type="hidden" value="0">
                                <?php 
                                    echo anchor('budget/propose_budget_c/propose_budget_revision', 'Cancel', 'class="btn btn-default"');
                                ?>
                                <button id="propose" type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Propose</button>
                            </div>
                        </div>                    
                    </div>
                </div>
            </form>
        </div>                
    </section>
</aside>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.13.4/jquery.mask.min.js"></script>
<script>
    function getNoBudget(value) {
        var kd_dept = document.getElementById('dept').value;
        var kd_bgt = document.getElementById('bgt_type').value;
        var kd_sect = document.getElementById('list_section').value;
        var kd_thn = document.getElementById('tahun').value;
        $.ajax({
            async: false,
            type: "POST",
            url: "<?php echo site_url('budget/propose_budget_c/generate_no_budget'); ?>",
            data: "id_bgt=" + kd_bgt + "&id_dept=" + kd_dept + "&id_sect=" + kd_sect + "&id_thn=" + kd_thn,
            success: function(data) {
                console.log(data);
                $("#budget_no").val(data);
            },
            error: function(data){
                console.log(data);
                alert('error');
            }
        });
    }
    
    function getCategory(value) {
        $.ajax({
            async: false,
            type: "POST",
            url: "<?php echo site_url('budget/propose_budget_c/get_list_category'); ?>",
            data: "type_budget=" + value,
            success: function(data) {
                console.log(data);
                $("#list_category").html(data);
            },
            error: function(data){
                console.log(data);
                alert('error');
            }
        });
    }
    
    function getSection(value) {
        if(value != ""){
            $.ajax({
                async: false,
                type: "POST",
                url: "<?php echo site_url('budget/propose_budget_c/get_list_section'); ?>",
                data: "kode_dept=" + value,
                success: function(data) {
                    $("#list_section").html(data);
                },
                error: function(data){
                    console.log(data);
                    alert('error');
                }
            });
        } else {
           document.getElementById('list_section').value = '';
        }
    }
    
    $(document).on("change", "#bgt_type", function() {
        if ($(this).val() == "CAPEX") {
            document.getElementById('cip').style.display = 'block';
        } else {
            document.getElementById('cip').style.display = 'none';
        }
    });
    
    $(document).on("change", "#status", function() {
        if ($(this).val() == "1") {
            document.getElementById('project').style.display = 'block';
            document.getElementById('purpose').style.display = 'none';
        } else if ($(this).val() == "0"){
            document.getElementById('project').style.display = 'none';
            document.getElementById('purpose').style.display = 'block';
        } else {
            document.getElementById('project').style.display = 'none';
            document.getElementById('purpose').style.display = 'none';
        }
    });
    
    $('.money').mask("#.##0", {reverse: true});
    
    $(document).on("change", ".money", function() {
        var sum = 0;
        $(".money").each(function(){
            var amo = $(this).val().replace(/[.]/g,"");
            sum += +amo;            
        });
        var tot_amo = sum.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
        $(".money_tot").val(tot_amo);
    });
    
    $(document).on("change", ".qty", function() {
        var sum = 0;
        $(".qty").each(function(){
            sum += +$(this).val();            
        });
        $(".qty_tot").val(sum);
    });
    
    $(document).on("change", "#note", function() {
        if ($(this).val().length < 5) {
            document.getElementById('alert_3').style.display = 'block';
        } else {
            document.getElementById('alert_3').style.display = 'none';
        }
    });
    
    $(document).on("change", ".money", function() {
        var sum = 0;
        var count = 0;
        $(".money").each(function(){
            var amo = $(this).val().replace(/[.]/g,"");
            sum += +amo;
            if(amo > 0){
                count += +1;
            }            
        });
        var bgt_type = document.getElementsByName("CHR_TYPE_BUDGET")[0].value;
        if(bgt_type == "CAPEX"){
            if(sum < 3000000){
                document.getElementById('alert_1').style.display = 'block';
                document.getElementById("propose").disabled = true;
                if(count > 1){
                    document.getElementById('alert_2').style.display = 'block';
                } else {
                    document.getElementById('alert_2').style.display = 'none';
                }
            } else {
                document.getElementById('alert_1').style.display = 'none';
                if(count > 1){
                    document.getElementById('alert_2').style.display = 'block';
                    document.getElementById("propose").disabled = true;
                } else {
                    document.getElementById('alert_2').style.display = 'none';
                    document.getElementById("propose").disabled = false;
                }
            }            
        } else {
            document.getElementById('alert_1').style.display = 'none';
            document.getElementById('alert_2').style.display = 'none';
            document.getElementById("propose").disabled = false;
        }
    });

    
</script>
