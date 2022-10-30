<div class="grid">
    <div class="grid-header">
        <i class="fa fa-wrench"></i>
        <span class="grid-title">MASUKKAN KOMPONEN NG</span>
    </div>

    <div class="grid-body">
        <form method="POST" action="<?php echo site_url('pes/ng_no_locking/check/screen/engineering')?>" class="form-horizontal">
            <input name="RESET" type="submit" value="Reset" class="btn btn-primary pull-right" style="margin-left: 5px"></input>
            <input type="submit" value="Save" class="btn btn-primary pull-right" ></input>
            <div class="clear-fix"></div>
            <div class="ng-screen-login">
            <?php if (is_array($location)): ?>
                <div class="form-group">
                    <label class="col-sm-2 control-label">From Location</label>
                    <div class="col-sm-4">
                        <select name="CHR_SLOC_FROM" class="form-control">
                            <?php foreach ($location as $value): ?>
                             <option value="<?php echo $value;?>"><?php echo $value;?></option>
                            <?php endforeach;?>
                        </select>
                    </div>
                 </div>
            <?php else: ?>
                <div class="form-group">
                    <label class="col-sm-2 control-label">From Location</label>
                    <div class="col-sm-4">
                        <input type="text" name="CHR_SLOC_FROM" value="<?php echo $location;?>" class="form-control" readonly></input>
                    </div>
                 </div>
            <?php endif;?>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Area</label>
                    <div class="col-sm-4">
                        <input type="text" name="CHR_DESC_AREA" value="<?php echo @$area->CHR_DESC_AREA;?>" class="form-control" readonly=""></input>
                        <input type="hidden" name="CHR_AREA" value="<?php echo @$area->CHR_AREA;?>" readonly=""></input>
                    </div>
                </div>
        </form>
        <div class="col-md-12" align="center"><h4 style="color: red;padding-bottom: 30px;"><?php echo @$error;?></h4></div>
        <form method="POST" action="<?php echo site_url('pes/ng_no_locking/add_session/engineering')?>" class="form-horizontal">

                <div class="clear-fix"></div>
                <div class="form-group">
                    <div class="col-sm-12">
                        <div class="col-sm-2">
                            <input type="text" name="CHR_BACK_NO" id="back_no" class="form-control required" placeholder="Back Number" value="<?php echo @$CHR_BACK_NO;?>"></input>    
                        </div>
                        <div class="col-sm-2">
                            <input type="text" name="CHR_PART_NO" id="part_no" class="form-control required" placeholder="Part Number" value="<?php echo @$CHR_BACK_NO;?>"></input>
                        </div>
                        <div class="col-sm-1">
                        <input id="num" type="text" name="INT_TOTAL_QTY" class="form-control" placeholder="Quantity" value="<?php echo @$INT_TOTAL_QTY;?>" onKeyPress="return check(event,value)" onInput="checkLength()"></input>
                        </div>
                        <div class="col-sm-1">
                        <input id="uom" type="text" class="form-control" placeholder="UOM" name="CHR_UOM" readonly></input>
                        </div>
                        <div class="col-sm-3">
                            <!-- sella need edit 2016-03-17 -->
                             <select name="CHR_DAMAGE_CODE" class="form-control">
                                <?php foreach ($damage as $value): ?>
                                 <option value="<?php echo $value->CHR_DAMAGE_CODE .", ".$value->CHR_DAMAGE_DESC;?>"><?php echo $value->CHR_DAMAGE_CODE .",". $value->CHR_DAMAGE_DESC;?></option>
                                <?php endforeach;?>
                            </select>
                            <!-- <input type="text" name="CHR_DAMAGE_CODE" id="damage_code" class="form-control" placeholder="Damage Code" value="<?php echo @$CHR_DAMAGE_CODE;?>"></input> -->
                        </div>
                        <div class="col-sm-3"><input type="submit" class="btn btn-primary" value="Add"></input></div>
                    </div>
                </div>
                <div class="clear-fix"></div>
<!--                 <div class="clear-fix"></div>
<div class="form-group">
    <div class="col-sm-12">
        <div class="col-sm-3">
            <input type="text" name="CHR_BACK_NO" id="back_no" class="form-control required" placeholder="Back Number" value="<?php echo @$CHR_BACK_NO;?>"></input>    
        </div>
        <div class="col-sm-3">
        <input id="num" type="text" name="INT_TOTAL_QTY" class="form-control" placeholder="Quantity" value="<?php echo @$INT_TOTAL_QTY;?>" onKeyPress="return check(event,value)" onInput="checkLength()"></input>
        </div>
        <div class="col-sm-3">
            sella need edit 2016-03-17
             <select name="CHR_DAMAGE_CODE" class="form-control">
                <?php foreach ($damage as $value): ?>
                 <option value="<?php echo $value->CHR_DAMAGE_CODE;?>"><?php echo $value->CHR_DAMAGE_CODE .",". $value->CHR_DAMAGE_DESC;?></option>
                <?php endforeach;?>
            </select>
            <input type="text" name="CHR_DAMAGE_CODE" id="damage_code" class="form-control" placeholder="Damage Code" value="<?php echo @$CHR_DAMAGE_CODE;?>"></input>
        </div>
        <div class="col-sm-3"><input type="submit" class="btn btn-primary" value="Add"></input></div>
    </div>
</div>
<div class="clear-fix"></div> -->
                <hr>
            </form>
            </div>
        <div class="table">
            <?php echo $this->table->generate($table);?>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){

        $("#back_no").autocomplete({
            source:'<?php echo site_url();?>/pes/ng_no_locking/data/back_no/detail',
            minLength:1 ,
            select: function (event, ui) {
            event.preventDefault();
                $('#back_no').val(ui.item.label);
                $('#part_no').val(ui.item.value);
                $('#uom').val(ui.item.uom);
            }
        });
        $("#part_no").autocomplete({
            source:'<?php echo site_url();?>/pes/ng_no_locking/data/part_no/detail',
            minLength:1 ,
            select: function (event, ui) {
            event.preventDefault();
                $('#part_no').val(ui.item.label);
                $('#back_no').val(ui.item.value);
                $('#uom').val(ui.item.uom);
            }
        });
        $("#damage_code").autocomplete({
            source:'<?php echo site_url();?>/pes/ng_no_locking/data/damage_code',
            minLength:1 ,
        });
    });
    function check(e,value)
    {
        //Check Charater
        var unicode=e.charCode? e.charCode : e.keyCode;
        if (value.indexOf(".") != -1)if( unicode == 46 )return false;
        if (unicode!=8)if((unicode<48||unicode>57)&&unicode!=46)return false;
    }
    function checkLength()
    {
        var fieldLength = document.getElementById('num').value.length;
        //Suppose u want 4 number of character
        if(fieldLength <= 7){
            return true;
        }
        else
        {
            var str = document.getElementById('num').value;
            str = str.substring(0, str.length - 1);
            document.getElementById('num').value = str;
        }
    }
</script>