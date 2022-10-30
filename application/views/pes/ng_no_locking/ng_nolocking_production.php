<div class="grid">
    <div class="grid-header">
        <i class="fa fa-wrench"></i>
        <span class="grid-title">MASUKKAN KOMPONEN NG</span>
    </div>

    <div class="grid-body">
        <form method="POST" action="<?php echo site_url('pes/ng_no_locking/check/screen/production')?>" class="form-horizontal">
            <input name="RESET" type="submit" value="Reset" class="btn btn-primary pull-right" style="margin-left: 5px"></input>
            <input type="submit" value="Save" class="btn btn-primary pull-right" ></input>
            <div class="clear-fix"></div>
            <div class="ng-screen-login">
                <div class="form-group">
                    <label class="col-sm-2 control-label">From Location</label>
                    <div class="col-sm-4">
                        <input type="text" name="CHR_SLOC_FROM" value="<?php echo $location;?>" class="form-control" readonly></input>
                    </div>
                 </div>
               <?php if (isset($wc)): //add by reza req by vivin?>
                 <div class="form-group">
                    <label class="col-sm-2 control-label">Work Center</label>
                    <div class="col-sm-4">
                        <input type="text" name="CHR_WORK_CENTER" value="<?php echo @$wc;?>" class="form-control" readonly=""></input>                       
                    </div>
                </div>
              <?php endif;//end?>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Area</label>
                    <div class="col-sm-4">
                        <input type="text" name="CHR_DESC_AREA" value="<?php echo @$area->CHR_DESC_AREA;?>" class="form-control" readonly=""></input>
                        <input type="hidden" name="CHR_AREA" value="<?php echo @$area->CHR_AREA;?>" readonly=""></input>
                    </div>
                </div>
        </form>
        <div class="col-md-12" align="center"><h4 style="color: red;padding-bottom: 30px;"><?php echo @$error;?></h4></div>
        <form method="POST" action="<?php echo site_url('pes/ng_no_locking/add_session/production')?>" class="form-horizontal">
                <div class="form-group">

                <div class="clear-fix"></div>
                    <div class="col-sm-12">
                        <div class="col-sm-2">
                            <input type="text" name="CHR_BACK_NO" id="back_no" class="form-control" placeholder="Back Number"  value="<?php echo @$CHR_BACK_NO;?>"></input>    
                        </div>
                        <div class="col-sm-2"><input type="text" id="num" name="INT_TOTAL_QTY" class="form-control" autocomplete="off" placeholder="Quantity" value="<?php echo @$INT_TOTAL_QTY;?>" onKeyPress="return check(event,value)" onInput="checkLength()"></input></div>
                        <div class="col-sm-2">
                            <select name="CHR_REJECT_CODE" class="form-control">
                                <?php foreach ($reject as $value): ?>
                                 <option value="<?php echo $value->CHR_REJECT_CODE.",". $value->CHR_REJECT_TYPE;?>"><?php echo $value->CHR_REJECT_CODE .",". $value->CHR_REJECT_TYPE;?></option>
                                <?php endforeach;?>
                            </select>
                            <!-- <input type="text" name="CHR_REJECT_CODE" id="reject_code" class="form-control" placeholder="Reject Type" value="<?php echo @$CHR_REJECT_CODE;?>"></input> -->
                        </div>
                        <div class="col-sm-2">
                            <select name="CHR_NG_CATEGORY_CODE" class="form-control">
                                <?php foreach ($ng as $value): ?>
                                 <option value="<?php echo $value->CHR_NG_CATEGORY_CODE.",". $value->CHR_NG_CATEGORY;?>"><?php echo $value->CHR_NG_CATEGORY_CODE .",". $value->CHR_NG_CATEGORY;?></option>
                                <?php endforeach;?>
                            </select>
                            <!-- <input type="text" name="CHR_NG_CATEGORY_CODE" id="ng_category" class="form-control" placeholder="NG Category" value="<?php echo @$CHR_NG_CATEGORY_CODE;?>"></input> -->
                        </div>
                        <div class="col-sm-3"><input type="submit" class="btn btn-primary" value="Add"></input></div>
                    </div>
                </div>
                <div class="clear-fix"></div>
                <hr>
            </form>
            </div>
        <div class="table">
            <?php echo $this->table->generate(@$table);?>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){

        $("#back_no").autocomplete({
            source:'<?php echo site_url();?>/pes/ng_no_locking/data/back_no',
            minLength:1 ,
        });
        $("#reject_code").autocomplete({
            source:'<?php echo site_url();?>/pes/ng_no_locking/data/reject_code',
            minLength:1 ,
        });
        $("#ng_category").autocomplete({
            source:'<?php echo site_url();?>/pes/ng_no_locking/data/ng_category',
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