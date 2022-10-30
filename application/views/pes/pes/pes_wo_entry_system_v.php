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
  
  .noborder tr{
    border:none !important;
      padding: 10px;
  }
  
  .noborder tr td{
    border:none !important;
      padding: 10px;
  }

  .border tr td{
     border: 3px solid white;
    border-collapse: collapse;
  }
  .border tr{
       border: 3px solid white;
    border-collapse: collapse;
  }
   .border th{
       border: 3px solid white;
    border-collapse: collapse;
  }
  
   .label_inherit{
       font-weight: bold;
  }

 .btn-primary:hover, .btn-primary:focus, .btn-primary:active, .btn-primary.active, .open > .dropdown-toggle.btn-primary {
  background-color: #6F6 !important;
    border-color: #285e8e;
    color: #000 !important;
 }
  

</style>

<style>
input[type=radio] {
    display:none;
}
 
input[type=radio] + label {
    display:inline-block;
    margin:-2px;
    padding: 4px 12px;
    margin-bottom: 0;
    font-size: 14px;
    line-height: 20px;
    color: #333;
    text-align: center;
    text-shadow: 0 1px 1px rgba(255,255,255,0.75);
    vertical-align: middle;
    cursor: pointer;
    background-color: #f5f5f5;
    background-image: -moz-linear-gradient(top,#fff,#e6e6e6);
    background-image: -webkit-gradient(linear,0 0,0 100%,from(#fff),to(#e6e6e6));
    background-image: -webkit-linear-gradient(top,#fff,#e6e6e6);
    background-image: -o-linear-gradient(top,#fff,#e6e6e6);
    background-image: linear-gradient(to bottom,#fff,#e6e6e6);
    background-repeat: repeat-x;
    border: 1px solid #ccc;
    border-color: #e6e6e6 #e6e6e6 #bfbfbf;
    border-color: rgba(0,0,0,0.1) rgba(0,0,0,0.1) rgba(0,0,0,0.25);
    border-bottom-color: #b3b3b3;
    filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ffffffff',endColorstr='#ffe6e6e6',GradientType=0);
    filter: progid:DXImageTransform.Microsoft.gradient(enabled=false);
    -webkit-box-shadow: inset 0 1px 0 rgba(255,255,255,0.2),0 1px 2px rgba(0,0,0,0.05);
    -moz-box-shadow: inset 0 1px 0 rgba(255,255,255,0.2),0 1px 2px rgba(0,0,0,0.05);
    box-shadow: inset 0 1px 0 rgba(255,255,255,0.2),0 1px 2px rgba(0,0,0,0.05);
}
 
input[type=radio]:checked + label {
       background-image: none;
    outline: 0;
    -webkit-box-shadow: inset 0 2px 4px rgba(0,0,0,0.15),0 1px 2px rgba(0,0,0,0.05);
    -moz-box-shadow: inset 0 2px 4px rgba(0,0,0,0.15),0 1px 2px rgba(0,0,0,0.05);
    box-shadow: inset 0 2px 4px rgba(0,0,0,0.15),0 1px 2px rgba(0,0,0,0.05);
        background-color:#bfbfbf;
}
</style>

<?php

?>
<aside class="right-side">

    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/'); ?>"><span>Home</span></a></li>
            <li><a href="<?php echo base_url('index.php/pes/prodentry_c/'); ?>">Production Entry System</a></li>
            <!--<li><a href=""><strong>PRODUCTION ENTRY SYSTEM</strong></a></li>-->
        </ol>
    </section>
  
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="grid">  
                <form class="form-horizontal" method="post"  action="<?php echo base_url();?>index.php/pes/product_entry_c/save_product_entry" class="form-horizontal" role="form" ><!--style="background-color: #94D1DC"-->
                    <div class="grid-header">
                        <i class="fa fa-wrench"></i>
                        <span class="grid-title"><strong>PRODUCTION </strong> ENTRY SYSTEM</span>        
                    </div>
                    <div class="clearfix"></div>
                    <?php if($this->session->flashdata('message')<>''): ?>
                        <div class="alert alert-warning alert-dismissible" role="alert" id="alert_splash">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <?php echo $this->session->flashdata('message');?>
                        </div>
                       <br/>
                    <?php endif;?>
          <br/><br/>
                                 <div class="form-group">
                                    <label class="col-sm-2 control-label">Work Order Number</label>
                                    <div class="col-sm-4">
                                      <select id="e1"  name="work_order" class="populate" style="width:300px">
                                             <option ></option>
                                                       <?php foreach($work_order as $rows){
                                                         echo ' <option value="'.$rows->CHR_WO_NUMBER.'">'.$rows->CHR_WO_NUMBER.'</option>';
                                                              }
                                                          ?>
                                       </select>
                                    </div>
            
                                    <div class="col-sm-2">
                                        <button type="button" id="exec">Execute
                                    </div>
                           </div>        
                  <div class="form-group">
                  <label class="col-sm-2 control-label">Work Center</label>
                  <div class="col-sm-2">
                  <input type="text" name="work_center" id="work_center" class="form-control" style="width:200px" readonly="readonly">
                  </div>
                  </div>
                                    <div class="form-group">
                    <label class="col-sm-2 control-label">Shift</label>
                    <div class="col-sm-2">
                    <input type="text" name="shift"  id="shift" class="form-control" style="width:200px" readonly="readonly">  
                    <input type="hidden" name="hari" id="hari" class="form-control hari" placeholder="" readonly="readonly" style="width:300px">
                    <input type="hidden" name="date_wo" id="date_wo" class="form-control date_wo" placeholder="" readonly="readonly" style="width:300px">
                    <input type="hidden" name="CHR_VP" id="CHR_VP" class="form-control" placeholder="" readonly="readonly" style="width:300px">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label" style="font-weight: bold;">Jam</label><br/><br/>
                    <div class="col-sm-12">
                                          <!-- navigation select jam -->
                                            <div class="grid-body" id="shift1_0">
                                    <div class="btn-group" data-toggle="buttons">
                                                <label class="btn btn-primary" style="margin-right:5px">
                                                    <input name="jam" value="0600-0700" type="radio">06.00-07.00
                                                </label>
                                                <label class="btn btn-primary" style="margin-right:5px">
                                                    <input name="jam" value="0700-0800" type="radio">07.00-08.00
                                                </label>
                                                <label class="btn btn-primary" style="margin-right:5px">
                                                    <input name="jam" value="0800-0900" class="active" type="radio">08.00-09.00
                                                </label>
                                                <label class="btn btn-primary" style="margin-right:5px">
                                                    <input name="jam" value="0900-1000" type="radio">09.00-10.00
                                                </label>
                                                <label class="btn btn-primary" style="margin-right:5px">
                                                    <input name="jam" value="1000-1100" type="radio">10.00-11.00
                                                </label>
                                                <label class="btn btn-primary" style="margin-right:5px">
                                                    <input name="jam" value="1100-1200" type="radio">11.00-12.00
                                                </label>
                                                <label class="btn btn-primary" style="margin-right:5px">
                                                    <input name="jam" value="1200-1300" type="radio">12.00-13.00
                                                </label>
                                                <label class="btn btn-primary" style="margin-right:5px">
                                                    <input name="jam" value="1300-1400" type="radio">13.00-14.00
                                                </label>
                                                 <label class="btn btn-primary" style="margin-right:5px">
                                                    <input name="jam" value="1400-1500" type="radio">14.00-15.00
                                                </label>
                                                <label class="btn btn-primary" style="margin-right:5px">
                                                    <input name="jam" value="1500-1600" type="radio">15.00-16.00
                                                </label>
                                                <label class="btn btn-primary" style="margin-right:5px">
                                                    <input name="jam" value="1600-1700" type="radio">16.00-17.00
                                                </label>
                                                <label class="btn btn-primary" style="margin-right:5px">
                                                    <input name="jam" value="1700-1800" type="radio">17.00-18.00
                                                </label>
                                                <label class="btn btn-primary" style="margin-right:5px">
                                                    <input name="jam" value="1800-1900" type="radio">18.00-19.00
                                                </label>
                                                <label class="btn btn-primary" style="margin-right:5px">
                                                    <input name="jam" value="1900-2000" type="radio">19.00-20.00
                                                </label>
                                                <label class="btn btn-primary" style="margin-right:5px">
                                                    <input name="jam" value="2000-2100" type="radio">20.00-21.00
                                                </label>
                                                <label class="btn btn-primary" style="margin-right:5px">
                                                    <input name="jam" value="2100-2200" type="radio">21.00-22.00
                                                </label>
                                                <label class="btn btn-primary" style="margin-right:5px">
                                                    <input name="jam" value="2200-2300" type="radio">22.00-23.00
                                                </label>
                                                <label class="btn btn-primary" style="margin-right:5px">
                                                    <input name="jam" value="2300-2400" type="radio">23.00-24.00
                                                </label>
                                                <label class="btn btn-primary" style="margin-right:5px">
                                                    <input name="jam" value="0000-0100" type="radio">24.00-01.00
                                                </label>
                                                <label class="btn btn-primary" style="margin-right:5px">
                                                    <input name="jam" value="0100-0200" type="radio">01.00-02.00
                                                </label>
                                                <label class="btn btn-primary" style="margin-right:5px">
                                                    <input name="jam" value="0200-0300" type="radio">02.00-03.00
                                                </label>
                                                <label class="btn btn-primary" style="margin-right:5px">
                                                    <input name="jam" value="0300-0400" type="radio">03.00-04.00
                                                </label>
                                                <label class="btn btn-primary" style="margin-right:5px">
                                                    <input name="jam" value="0400-0500" type="radio">04.00-05.00
                                                </label>
                                                <label class="btn btn-primary" style="margin-right:5px">
                                                    <input name="jam" value="0500-0600" type="radio">05.00-06.00
                                                </label>
                                               
                                                
                                                 
                                            </div>                                       
                  </div>
                                      
                                    

                    <!-- navigation table middle -->
                    <div class="table-responsive">
          <table class="table noborder" cellpadding="10" style="margin: 10px;">
                              <tr>
                                <td>Tanggal</td>
                                <td><input type="text" name="tanggal" id="tgl" class="form-control" placeholder="" readonly="readonly" style="width:200px">
                                <td>&nbsp;</td>
                                <td>Type</td>
                                <td>
                                  <input type="text" name="type" id="type" class="form-control" placeholder="" style="width:200px" readonly/>
                                </td>
                                <td>&nbsp;</td>
                              </tr>
                              <tr>
                                <td>Back Number</td>
                                <td><!--<select id="e2"  name="select_back_number" class="populate" style="width:300px"  onChange="jsFunction()" >
                                         <option ></option>
                                          <?php foreach($back_number as $rows){
                                           echo ' <option value="'.$rows->CHR_BACK_NO.'">'.$rows->CHR_BACK_NO.'</option>';
                                              }
                                          ?>
                                      </select>-->
                                  <input type="text" name="CHR_BACK_NO" id="back_no" class="form-control" placeholder=""  value="" style="width:200px; text-transform:uppercase" onblur="test()" onkeyup="javascript:this.value=this.value.toUpperCase();"></input> 
                                  <!--<input type="text" name="CHR_BACK_NO2" id="back_no2" class="form-control" placeholder=""  value="" style="width:200px"></input> -->

                                
                                </td>
                                <td>&nbsp;</td>
                                <td>Target / Jam</td>
                                <td>
                                  <input type="text" name="target_jam" class="form-control target_jam" id="target_jam" placeholder="" style="width:200px" readonly/>
                                </td>
                                <td>&nbsp;</td>
                              </tr>
                              <tr>
                                <td>Part Number</td>
                                <td><input type="text" name="part_number" id ="part_number" class="form-control" placeholder="" style="width:300px" readonly="readonly">
                                </td>
                                <td>&nbsp;</td>
                                <td>Actual / Jam</td>
                                <td>
                                  <input type="text" name="actual_jam" class="form-control" id="actual_jam" placeholder="" readonly />
                                </td>
                                <td>&nbsp;</td>
                              </tr>
                              <tr>
                                <td>Part Name & Model</td>
                                <td>
                                         <input type="text" name="part_name" class="form-control" id="part_name" placeholder="" style="width:300px"  readonly="readonly">
                                </td>
                                <td>&nbsp;</td>
                                <td>Line Stop/Jam</td>
                                <td>
                                  <input type="text" name="line_stop_jam" id="line_stop_jam" class="form-control" placeholder="" readonly />
                                </td>
                                <td>menit</td>
                              </tr>
                              <tr>
                                <td>Jumlah MP</td>
                                <td>
                                    <div class="row">
                                        <div class="col-md-4">
                                         <input type="text" name="INT_MP" class="form-control INT_MP cols-md-2 angka" id="INT_MP" autocomplete="off" placeholder="" required onblur="getRumus()">             
                                        </div>
                                        <div class="col-md-3">
                                             &nbsp; 
                                        </div>
                                    </div>
                                </td>
                                <td>&nbsp;</td>
                                <td>Chokotei</td>
                                <td>
                                  <input type="text" name="chokotei" class="form-control chokotei" id="chokotei" placeholder=""  readonly />
                                </td>
                                <td>menit</td>
                              </tr>
                              <tr>
                                <td>Qty Produksi</td>
                                <td>&nbsp;
                                    
                                </td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;
                                  
                                </td>
                                <td>&nbsp;</td>
                              </tr>
                                <tr>
                                <td>OK</td>
                                <td>
                                    <div class="row">
                                        <div class="col-md-4">
                                         <input type="text" name="jml_mp" class="form-control angka" id="jml_mp" placeholder="" required >             
                                        </div>
                                        <div class="col-md-3">
                                             <input type="text" name="qty_uom" class="form-control" id="qty_uom" style="width:50px" placeholder="" readonly>    
                                        </div>
                                    </div>
                                   
                                </td>
                                <td>&nbsp;</td>
                                
                              </tr>
                </table>
        </div>
 <div style="overflow-x:scroll; overflow-y: hidden;">
                
                 <div class="row">
                   <div class="col-md-8">
                       
                      <label style="margin: 15px; font-weight: bold;">QTY NG</label>
                      <table class="table border" style="margin: 10px;">
                        <thead>
                          <tr>
                            <th>Jenis Reject</th>
                            <th>Kategori NG</th>
                            <th>Qty NG</th>
                            <th>Uom</th>
                            <th>Kode Area</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td><select id="reject1"  name="CHR_REJECT_CODE[]" class="populate" style="width:200px">
                            <option ></option>
                            <?php foreach($reject_status as $rows){
                                echo ' <option value="'.trim($rows->CHR_REJECT_CODE).'">'.$rows->CHR_REJECT_TYPE.'</option>';
                                 }
                           ?>
                          </select></td>
                            <td><select id="ng1"  name="CHR_NG_CATEGORY_CODE[]" class="populate" style="width:200px">
                            <option ></option>
                            <?php foreach($ng_status as $rows){
                                               echo ' <option value="'.trim($rows->CHR_NG_CATEGORY_CODE).'">'.$rows->CHR_NG_CATEGORY.'</option>';
                                                  }
                                              ?>
                          </select></td>
                            <td><input type="text" id="qty_ng1" name="qty_ng[]" class="form-control qty_ng angka" style="width:100px"  value="" autocomplete="off" placeholder="" /></td>
                            <td><input type="text" id="uom1" name="uom[]" class="form-control" style="width:50px" placeholder="" readonly /></td>
                            <td><select id="area1"  name="CHR_AREA[]" class="populate" style="width:200px">
                            <option id="selectarea1"></option>
                         
                          </select></td>
                          </tr>
                            
                          <tr>
                            <td><select id="reject2"  name="CHR_REJECT_CODE[]" class="populate" style="width:200px">
                            <option ></option>
                            <?php foreach($reject_status as $rows){
                                echo ' <option value="'.trim($rows->CHR_REJECT_CODE).'">'.$rows->CHR_REJECT_TYPE.'</option>';
                                 }
                           ?>
                          </select></td>
                            <td><select id="ng2"  name="CHR_NG_CATEGORY_CODE[]" class="populate" style="width:200px">
                            <option ></option>
                            <?php foreach($ng_status as $rows){
                                               echo ' <option value="'.trim($rows->CHR_NG_CATEGORY_CODE).'">'.$rows->CHR_NG_CATEGORY.'</option>';
                                                  }
                                              ?>
                          </select></td>
                            <td><input type="text" id="qty_ng2" name="qty_ng[]" class="form-control qty_ng angka" style="width:100px"autocomplete="off" value="" placeholder="" /></td>
                            <td><input type="text" id="uom2" name="uom[]" class="form-control" style="width:50px" placeholder="" readonly /></td>
                            <td><select id="area2"  name="CHR_AREA[]" class="populate" style="width:200px">
                            <option id="selectarea2"></option>
                          </select></td>
                          </tr>
                            
                          <tr>
                            <td><select id="reject3"  name="CHR_REJECT_CODE[]" class="populate" style="width:200px">
                            <option ></option>
                            <?php foreach($reject_status as $rows){
                                echo ' <option value="'.trim($rows->CHR_REJECT_CODE).'">'.$rows->CHR_REJECT_TYPE.'</option>';
                                 }
                           ?>
                          </select></td>
                            <td><select id="ng3"  name="CHR_NG_CATEGORY_CODE[]" class="populate" style="width:200px">
                            <option ></option>
                            <?php foreach($ng_status as $rows){
                                               echo ' <option value="'.trim($rows->CHR_NG_CATEGORY_CODE).'">'.$rows->CHR_NG_CATEGORY.'</option>';
                                                  }
                                              ?>
                          </select></td>
                            <td><input type="text" id="qty_ng3" name="qty_ng[]" class="form-control qty_ng angka" style="width:100px"autocomplete="off" value="" placeholder="" /></td>
                            <td><input type="text" id="uom3" name="uom[]" class="form-control" style="width:50px" placeholder="" readonly /></td>
                            <td><select id="area3"  name="CHR_AREA[]" class="populate" style="width:200px">
                            <option id="selectarea3"></option>
                          </select></td>
                          </tr>
                            
                          <tr>
                            <td><select id="reject4"  name="CHR_REJECT_CODE[]" class="populate" style="width:200px">
                            <option ></option>
                            <?php foreach($reject_status as $rows){
                                echo ' <option value="'.trim($rows->CHR_REJECT_CODE).'">'.$rows->CHR_REJECT_TYPE.'</option>';
                                 }
                           ?>
                          </select></td>
                            <td><select id="ng4"  name="CHR_NG_CATEGORY_CODE[]" class="populate" style="width:200px">
                            <option ></option>
                            <?php foreach($ng_status as $rows){
                                               echo ' <option value="'.trim($rows->CHR_NG_CATEGORY_CODE).'">'.$rows->CHR_NG_CATEGORY.'</option>';
                                                  }
                                              ?>
                          </select></td>
                            <td><input type="text" id="qty_ng4" name="qty_ng[]" class="form-control qty_ng angka" style="width:100px" autocomplete="off" value="" placeholder="" /></td>
                            <td><input type="text" id="uom4" name="uom[]" class="form-control" style="width:50px" placeholder="" readonly /></td>
                            <td><select id="area4"  name="CHR_AREA[]" class="populate" style="width:200px">
                            <option id="selectarea4"></option>
                          </select></td>
                          </tr>
                          
                          <tr>
                            <td><select id="reject5"  name="CHR_REJECT_CODE[]" class="populate" style="width:200px">
                            <option ></option>
                            <?php foreach($reject_status as $rows){
                                echo ' <option value="'.trim($rows->CHR_REJECT_CODE).'">'.$rows->CHR_REJECT_TYPE.'</option>';
                                 }
                           ?>
                          </select></td>
                            <td><select id="ng5"  name="CHR_NG_CATEGORY_CODE[]" class="populate" style="width:200px">
                            <option ></option>
                            <?php foreach($ng_status as $rows){
                                               echo ' <option value="'.trim($rows->CHR_NG_CATEGORY_CODE).'">'.$rows->CHR_NG_CATEGORY.'</option>';
                                                  }
                                              ?>
                          </select></td>
                            <td><input type="text" id="qty_ng5" name="qty_ng[]" class="form-control qty_ng angka" style="width:100px" value="" autocomplete="off" placeholder="" /></td>
                            <td><input type="text" id="uom5" name="uom[]" class="form-control" style="width:50px" placeholder="" readonly /></td>
                            <td><select id="area5"  name="CHR_AREA[]" class="populate" style="width:200px">
                            <option id="selectarea5"></option>
                          </select></td>
                          </tr>
                          
                          <tr>
                            <td><select id="reject6"  name="CHR_REJECT_CODE[]" class="populate" style="width:200px">
                            <option ></option>
                            <?php foreach($reject_status as $rows){
                                echo ' <option value="'.trim($rows->CHR_REJECT_CODE).'">'.$rows->CHR_REJECT_TYPE.'</option>';
                                 }
                           ?>
                          </select></td>
                            <td><select id="ng6"  name="CHR_NG_CATEGORY_CODE[]" class="populate" style="width:200px">
                            <option ></option>
                            <?php foreach($ng_status as $rows){
                                               echo ' <option value="'.trim($rows->CHR_NG_CATEGORY_CODE).'">'.$rows->CHR_NG_CATEGORY.'</option>';
                                                  }
                                              ?>
                          </select></td>
                            <td><input type="text" id="qty_ng6" name="qty_ng[]" class="form-control qty_ng angka"style="width:100px" value="" autocomplete="off" placeholder="" /></td>
                            <td><input type="text" id="uom6" name="uom[]" class="form-control" style="width:50px" placeholder="" readonly /></td>
                            <td><select id="area6"  name="CHR_AREA[]" class="populate" style="width:200px">
                            <option id="selectarea6"></option>
                          </select></td>
                          </tr>
                          
                          <tr>
                            <td><select id="reject7"  name="CHR_REJECT_CODE[]" class="populate" style="width:200px">
                            <option ></option>
                            <?php foreach($reject_status as $rows){
                                echo ' <option value="'.trim($rows->CHR_REJECT_CODE).'">'.$rows->CHR_REJECT_TYPE.'</option>';
                                 }
                           ?>
                          </select></td>
                            <td><select id="ng7"  name="CHR_NG_CATEGORY_CODE[]" class="populate" style="width:200px">
                            <option ></option>
                            <?php foreach($ng_status as $rows){
                                               echo ' <option value="'.trim($rows->CHR_NG_CATEGORY_CODE).'">'.$rows->CHR_NG_CATEGORY.'</option>';
                                                  }
                                              ?>
                          </select></td>
                            <td><input type="text" id="qty_ng7" name="qty_ng[]" class="form-control qty_ng angka" style="width:100px" value="" autocomplete="off" placeholder="" /></td>
                            <td><input type="text" id="uom7" name="uom[]" class="form-control" style="width:50px" placeholder="" readonly /></td>
                            <td><select id="area7"  name="CHR_AREA[]" class="populate" style="width:200px">
                            <option id="selectarea7"></option>
                          </select></td>
                          </tr>
                          <tr>
                            <td><select id="reject8"  name="CHR_REJECT_CODE[]" class="populate" style="width:200px">
                            <option ></option>
                            <?php foreach($reject_status as $rows){
                                echo ' <option value="'.trim($rows->CHR_REJECT_CODE).'">'.$rows->CHR_REJECT_TYPE.'</option>';
                                 }
                           ?>
                          </select></td>
                            <td><select id="ng8"  name="CHR_NG_CATEGORY_CODE[]" class="populate" style="width:200px">
                            <option ></option>
                            <?php foreach($ng_status as $rows){
                                               echo ' <option value="'.trim($rows->CHR_NG_CATEGORY_CODE).'">'.$rows->CHR_NG_CATEGORY.'</option>';
                                                  }
                                              ?>
                          </select></td>
                            <td><input type="text" id="qty_ng8" name="qty_ng[]" class="form-control qty_ng angka" style="width:100px" value="" autocomplete="off" placeholder="" /></td>
                            <td><input type="text" id="uom8" name="uom[]" class="form-control" style="width:50px" placeholder="" readonly /></td>
                            <td><select id="area8"  name="CHR_AREA[]" class="populate" style="width:200px">
                            <option id="selectarea8"></option>
                          </select></td>
                          </tr>
                          
                          <tr>
                           <td colspan="2">Total Qty Produksi</td>
                           <td><input type="text" name="qty_total" class="form-control" id="qty_total" style="width:100px" placeholder="" readonly/></td>
                           <td><input type="text" name="uom_qty_Prod" id="uom_qty_Prod" class="form-control" style="width:50px" placeholder=""  readonly/></td>
                           <td>&nbsp;</td>
                          </tr>
                        </tbody>
                      </table>
                    


                   </div>
                   <div class="col-md-4">
                      <table class="table border">
                        <thead>
                          <tr>
                            <th>Line Stop</th>
                            <th>menit</th>
                            <th>Keterangan</th>
                          </tr>
                        </thead>
                        <tbody>
                         <?php foreach($chr_line_stop as $row){ ?>
                         <tr>
                            <td><?php echo ucfirst($row->CHR_LINE_STOP);?>
                            <input type="hidden" name="CHR_LINE_CODE[]" style="width:100px" class="form-control" placeholder="" value="<?php echo ucfirst($row->CHR_LINE_CODE);?>"/> 
                            <input type="hidden" name="CHR_LINE_CAT[]" style="width:100px" class="form-control" placeholder="" value="<?php if($row->CHR_LINE_CAT == 1){
                               echo 'X';
                           };?>"/> 
                            </td>
                            
                            <td><input type="text" name="menit[]" id="menit" style="width:100px" class="form-control menit angka menit<?php echo trim($row->CHR_LINE_CODE);?> " placeholder="" autocomplete="off" /></td>
                            <td><input type="text" name="keterangan[]" class="form-control keterangan<?php echo trim($row->CHR_LINE_CODE);?> " placeholder="" /></td>
                         </tr>
                         <?php }?>
                          <tr>
                            <td>Total Line Stop</td>
                            <td><input type="text" name="total_linestop"  id="total_linestop" style="width:100px" class="form-control total_linestop" placeholder="" readonly/></td>
                            <td>&nbsp;</td>
                         </tr>
                        </tbody>
                      </table>
                    
                   </div>
                 </div>
               </div>
                    <br/><br/><br/><br/>
                    
               
                    <!--- navigation bottom -->
                                      
                    
                    
                        </div>
            </div>
                                    
                                  
              </div>
              </div
                         ></div>
                         <button class="btn btn-primary btn-lg pull-left" type="submit">save</button>
                         </form>
                       </div> 
                    </div>                                                      
                </div>
  
    </section>
</aside>

<script>
// $('#shift1_1').hide();
// $('#shift1_0').hide();
// $('#shift2').hide();
// $('#shift3').hide();
// $('#shift0_1').hide();
// $('#shift0_0').hide();



$(function(){ // start of doc ready.
   $("#exec").click(function(e){
      e.preventDefault();  // stops the jump when an anchor clicked.
      var title = $(this).text(); // anchors do have text not values.
    
      $.ajax({
        url :"<?php echo base_url()?>index.php/pes/product_entry_c/get_Work_order_by_id",
        data: {'title': title}, // change this to send js object
        type: "POST",
    data:{data:$('#e1').val()},
    dataType:"json",
        success: function(data){
           //document.write(data); just do not use document.write

           console.log(data);
       //$('#work_order').val($('#e1').val().trim()+'/'+str[1]+str[0]+str[2]+'/SHIFT'+$('#shift').val());
       $('#work_center').val(data.CHR_WORK_CENTER);
       $('#shift').val(data.CHR_SHIFT);
       var responsible=data.CHR_PERSON_RESPONSIBLE;
       var area=data.CHR_AREA;
       var desc=data.CHR_DESC_AREA;
       var res = area.concat(","," ",desc);
       if (responsible=='014') {
        $('#selectarea1').html(res);
        $('#selectarea2').html(res);
        $('#selectarea3').html(res);
        $('#selectarea4').html(res);
        $('#selectarea5').html(res);
        $('#selectarea6').html(res);
        $('#selectarea7').html(res);
        $('#selectarea8').html(res);

       }else{
        $('#selectarea1').attr("readonly", true); 
        $('#selectarea2').attr("readonly", true); 
        $('#selectarea3').attr("readonly", true); 
        $('#selectarea4').attr("readonly", true); 
        $('#selectarea5').attr("readonly", true); 
        $('#selectarea6').attr("readonly", true); 
        $('#selectarea7').attr("readonly", true); 
        $('#selectarea8').attr("readonly", true); 
       }
       
    
       //display jam
       var shift=data.CHR_SHIFT;
       var day=data.CHR_WORK_DAY;
       
       var date_wo = data.CHR_DATE;
      
       
       var res1 = date_wo.substring(0, 4);
       var res2 = date_wo.substring(4, 6);
       var res3 = date_wo.substring(6, 8);
        
       /*if(res2.length==1){
         var2='0'+res2; 20160223
         }
      if(res3.length==1){
         var3='0'+res3;
         }*/
         
       //alert(res1+'/'+res2+'/'+res3);
       $('#tgl').val(res3+'/'+res2+'/'+res1);
       $('#hari').val(day);
       $('#date_wo').val(date_wo);
       $('#CHR_VP').val(data.INT_PV);
           $("#alert_splash").hide();
        }
      });
   });
}); // end of doc ready
</script>

<script>
jQuery(document).ready(function () {
  $(".populate").select2();
  $('#e1').select2({
        allowClear: true
    }).on("change", function(e) {
            $("#e1").val(e.val);
   });

    $("input[name=jam]").change(function () {
        getRumus();
        $("#back_no2").val(1234);

    });

    //$("input[name=CHR_BACK_NO]").change(function () {
    $("#back_no").blur(function () {
		alert("Masuk");
        jsFunction();
        //cekJam();
        //getRumus();
        //getDataExist();
       // jsFunction();
       
    });

   //    $("#back_no").bind('change', function() {
   //     // yada yada
   //     alert('tets');
   // });

   

  $('.angka').keydown(function(e) { 
       // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
             // Allow: Ctrl+A, Command+A
            (e.keyCode == 65 && ( e.ctrlKey === true || e.metaKey === true ) ) || 
             // Allow: home, end, left, right, down, up
            (e.keyCode >= 35 && e.keyCode <= 40)) {
                 // let it happen, don't do anything
                 return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
  });
  
  $(".qty_ng").keyup(function(){
    var qtyok = document.getElementsByName("jml_mp")[0].value;//penambahan untuk qtyok
    //alert(qtyok);
    var qty_total=qtyok;
    $(".qty_ng").each(function(){
      if(this.value){
        qty_total = parseInt(qty_total) + parseInt(this.value);
      }
    });
    $("#qty_total").val(qty_total);
  }); 
  

  $("#jml_mp").keyup(function(){
    //alert(this.value);
    if(this.value){
        $("#qty_total").val(parseInt(this.value));
    }

    else{
        $("#qty_total").val(0);   
    }
  }); //jml_mp


  $(".menit").keyup(function(){
    lineStop();
  });

  
  var optionsList = $.map(
    [{value: 1, label: 'first'}, {value: 2, label: 'second'}, {value: 3, label: 'third'}, {value: 4, label: 'fourth'}],
    function (obj) {
  obj.id = obj.id || obj.value;
  obj.text = obj.text || obj.label;
 
  return obj;
});

  $("#example_select2").select2({ 
    data: optionsList,
    dropdownAutoWidth: true                       
  });


  $("#back_no").autocomplete({

            source:'<?php echo site_url();?>/pes/ng_no_locking/data/back_no',
            minLength:1 ,
        });
  
  

  //assign value to new variable

  //alert-dismissible
  $("#alert-dismissible").select2({ 
    data: optionsList,
    dropdownAutoWidth: true                       
  });
  
  // $("#alert_splash").delay(1000).hide(0, function() {
  //   //$("#div2").show();
  //   });

});


</script>



<script type='text/javascript'>
function jsFunction(){

  var param = $.trim($("#back_no").val());

  $.ajax({
        url :"<?php echo base_url()?>index.php/pes/product_entry_c/get_back_no_attribute/"+param,
        //data: {'title': title}, // change this to send js object
        type: "GET",
    //data:{data:$('#e2').val()},
    dataType:"json",
        success: function(data){
           //document.write(data); just do not use document.write
           console.log(data);
       
      //alert(var3+'/'+var2+'/'+res1);
       //$('#tgl').val(var3+'/'+var2+'/'+res1);
       $('#part_number').val(data.CHR_PART_NO);
       $('#part_name').val(data.CHR_PART_NAME);
       $('#type').val(data.CHR_TYPE);
           $('#qty_uom').val(data.CHR_PART_UOM);
           $('#uom1').val(data.CHR_PART_UOM);
           $('#uom2').val(data.CHR_PART_UOM);
           $('#uom3').val(data.CHR_PART_UOM);
           $('#uom4').val(data.CHR_PART_UOM);
           $('#uom5').val(data.CHR_PART_UOM);
           $('#uom6').val(data.CHR_PART_UOM);
           $('#uom7').val(data.CHR_PART_UOM);
           $('#uom8').val(data.CHR_PART_UOM);
           $('#uom_qty_Prod').val(data.CHR_PART_UOM);
            //uom8
           getRumus();
           getDataExist();

           var CHR_PV = data.CHR_PV || 0;
           if(CHR_PV == 0){
              alert('Master Data Production Version belum ada')
          }

        }

        
      });
    
   
}
</script>

<script>
function onBlurFunction() {
    
  var val= $("input[name=jam]").val();
  $().
  
  alert(val);
  
}
</script>

<script>
jQuery(document).ready(function () {

 
 // $(".populate").select2();
  $('#area1').select2({
        allowClear: true
    }).on("change", function(e) {
            var value = $("#area1").val(e.val);
           // alert(value);
   });

$('#area2').on('change', function() {
   
    if($("#area1").val() != this.value){
        alert('Kode Area Tidak Sama, Silahkan Pilih Kode Area' ); 
         $('#area2').val('');
    }
    else{
        //alert('sama' ); 
    }
    
});

$('#area3').on('change', function() {
   
    if($("#area1").val() != this.value){
        alert('Kode Area Tidak Sama, Silahkan Pilih Kode Area' ); 
         $('#area3').val('');
    }
    else{
        //alert('sama' ); 
    }
    
});

$('#area4').on('change', function() {
   
    if($("#area1").val() != this.value){
        alert('Kode Area Tidak Sama, Silahkan Pilih Kode Area' ); 
         $('#area4').val('');
    }
    else{
        //alert('sama' ); 
    }
    
});

$('#area5').on('change', function() {
   
    if($("#area1").val() != this.value){
        alert('Kode Area Tidak Sama, Silahkan Pilih Kode Area' ); 
         $('#area5').val('');
    }
    else{
        //alert('sama' ); 
    }
    
});

$('#area6').on('change', function() {
   
    if($("#area1").val() != this.value){
        alert('Kode Area Tidak Sama, Silahkan Pilih Kode Area' ); 
         $('#area6').val('');
    }
    else{
        //alert('sama' ); 
    }
    
});

$('#area7').on('change', function() {
   
    if($("#area1").val() != this.value){
        alert('Kode Area Tidak Sama, Silahkan Pilih Kode Area' ); 
         $('#area7').val('');
    }
    else{
        //alert('sama' ); 
    }
    
});

$('#area8').on('change', function() {
   
    if($("#area1").val() != this.value){
        alert('Kode Area Tidak Sama, Silahkan Pilih Kode Area' ); 
         $('#area8').val('');
    }
    else{
        //alert('sama' ); 
    }
    
});


});
</script>

<script>
function getRumus() {
        var CHR_WORK_TIME_START = $.trim(($("input[name=jam]:checked").val().substr(0, 4))); //work_order
        var work_center = $.trim($("input[name=work_center]").val());
        var work_order =$.trim($("#e1").val());
        var chr_work_shift = $.trim($("input[name=shift]").val());
        var chr_work_day = $.trim($("input[name=hari]").val());
        //var chr_work_start = $("input[name=jam]").val();
        var date_wo = $("#date_wo").val();
        var int_thn = date_wo.substring(0, 4);
        var int_bln = date_wo.substring(4, 6);
        
        //alert(CHR_WORK_TIME_START);

        $.ajax({
            url :"<?php echo base_url()?>index.php/pes/product_entry_c/get_back_rumus/"+chr_work_shift+"/"+chr_work_day+"/"+CHR_WORK_TIME_START+"/"+int_bln+"/"+int_thn+"/"+work_center+"/"+work_order,
            //url :"<?php echo base_url()?>index.php/pes/product_entry_c/get_back_rumus",
           
           //data: {'title': title}, // change this to send js object
            type: "GET",
            //data:{data:$('#e2').val()},
            dataType:"json",
            success: function(data){
                //alert(data);
               //document.write(data); just do not use document.write
               //alert(data.Work_Time);
               
               var INT_MP = $("#INT_MP").val(); 

               var work_time = data.work_time || 0;
               var INT_CT = data.INT_CT || 0;
               var ACTUAL_JAM = data.ACTUAL_JAM || 0;
               var plan_line_stop = data.plan_line_stop || 0;
               var TOTAL_LINE_STOP = data.TOTAL_LINE_STOP || 0;

               //alert(INT_MP);
               /*alert(work_time);
               alert(INT_CT);  
               alert(ACTUAL_JAM);  
               alert(plan_line_stop); 
               alert(TOTAL_LINE_STOP); 
               */

               var qtyh = ( 3600/(data.INT_CT) * (INT_MP));
               //alert(qtyh);
               
               
               //var TARGET = ((parseInt(data.work_time) - parseInt(data.plan_line_stop))/60)*parseInt(qtyh);
               var TARGET = (((work_time) - (plan_line_stop))/60)*(qtyh);
               //alert(TARGET);
               //var CHOKOTEI = (data.work_time - data.plan_line_stop);
               //var ACTUAL_JAM = (data.ACTUAL_JAM);
               //alert(data.work_time);
               //alert(data.plan_line_stop);

               var total_line_stop = (TOTAL_LINE_STOP);
               
               
               var CHOKOTEI = (((TARGET*data.INT_CT)/60) + data.TOTAL_LINE_STOP)-(((ACTUAL_JAM*data.INT_CT)/60)+data.TOTAL_LINE_STOP);
               //alert(CHOKOTEI);
               
                $('#target_jam').val(TARGET.toFixed(0));
                $('#chokotei').val(CHOKOTEI);
                $('#actual_jam').val(ACTUAL_JAM);
                $('#line_stop_jam').val(total_line_stop);
                
               
               
              // console.log(data);
               if (TARGET=="Infinity") {
                alert("Cek data cycle time di Target Produksi");
                window.location.href = "<?= base_url() ?>index.php/pes/product_entry_c/entry_system";
               }
            }
          });    
}
</script>

<script>
function getDataExist() {
        var CHR_WORK_TIME_START = $.trim(($("input[name=jam]:checked").val().substr(0, 4))); //work_order
        var chr_wo_num =$.trim($("#e1").val());
        var chr_back_no =$.trim($("#back_no").val());
        
       
        $.ajax({
            url :"<?php echo base_url()?>index.php/pes/product_entry_c/get_all_data/"+chr_back_no+"/"+CHR_WORK_TIME_START+"/"+chr_wo_num,
           
           //data: {'title': title}, // change this to send js object
            type: "GET",
            //data:{data:$('#e2').val()},
            dataType:"json",
            success: function(data){
               var flag = $.trim(data.flag);
               
               $('#INT_MP').val(data.result.INT_MP);
               $('#jml_mp').val(data.result.INT_QTY_OK);

               var chr_val = $.trim(data.result.CHR_VALIDATE);
                
               if(chr_val == 'X'){
                   alert("'Data Sudah Divalidate'" ); 
                   var redirect = "<?php echo base_url()?>"+"index.php/pes/product_entry_c/entry_system";
                   //alert(redirect); 
                  //window.location.reload();
                   window.location.replace(redirect);
               }

               $.each(data.LINE_STOP,function(i, item){

                $('.menit'+$.trim(item.CHR_LINE_CODE)).val(item.INT_MENIT);
                $('.keterangan'+$.trim(item.CHR_LINE_CODE)).val($.trim(item.CHR_REMARKS));
               });

               
               if(flag =='014'){
                  for(i=1;i<=8;i++){
                      $("#area"+i).select2('enable');
                    }
                   var x =1;
                 $.each(data.NG_L,function(i, item){

                  $("#reject"+x).select2('val' , $.trim(item.CHR_REJECT_CODE) );
                  $("#ng"+x).select2('val' , $.trim(item.CHR_NG_CATEGORY_CODE) );
                  $("#area"+x).select2('val' , $.trim(item.CHR_AREA) );
                  //$("#area"+x).select2().enable(false);
                  $('#qty_ng'+x).val(item.INT_TOTAL_QTY);
                  
                  x++;
                 });
                  
               }
               else{
                    for(i=1;i<=8;i++){
                      $("#area"+i).select2('disable');
                    }

                    var x =1

                    $.each(data.repair,function(i, item){

                  $("#reject"+x).select2('val' , $.trim(item.CHR_REJECT_CODE) );
                  $("#ng"+x).select2('val' , $.trim(item.CHR_NG_CATEGORY_CODE) );
                 // $("#area"+x).prop('disable', true);
                  //$("#area"+x).prop("readonly", true); 
                  
                  $('#qty_ng'+x).val(item.INT_TOTAL_QTY_NG);
                  
                   x++;
                 });  
               }
               
               lineStop();
               totalQty();
               cekJam();

               //console.log(data);
               
            }
          });    
}

function lineStop(){
     var qty_total=0;
      $(".menit").each(function(){
            if(this.value){
                console.log(this.value);
                qty_total += parseInt(this.value);
            }
      });
      $("#total_linestop").val(qty_total);
  }

  function totalQty(){
    var qtyok = document.getElementsByName("jml_mp")[0].value;//penambahan untuk qtyok
    //alert(qtyok);
    var qty_total=qtyok;
    $(".qty_ng").each(function(){
      if(this.value){
        qty_total = parseInt(qty_total) + parseInt(this.value);
      }
    });
    $("#qty_total").val(qty_total);
  }

  function cekJam(){
    var jam = $("input[name=jam]:checked").val();

    if(jam){
        //alert (jam);
        // getRumus();
        // getDataExist();
        // jsFunction();
    }
    else{
        alert ('Silahkan pilih jam terlebih dahulu');
        //$("#back_no").val('');
        
    }

  }

  function test(){
    //alert(this.value);
    
    jsFunction();
    //cekJam();
    getRumus();
    getDataExist();

  }
</script>

<script type="text/javascript"> 

function stopRKey(evt) { 
  var evt = (evt) ? evt : ((event) ? event : null); 
  var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null); 
  if ((evt.keyCode == 13) && (node.type=="text"))  {return false;} 
} 

document.onkeypress = stopRKey; 

</script>