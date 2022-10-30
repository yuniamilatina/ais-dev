<aside class="right-side">
     <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/'); ?>"><span>Home</span></a></li>
        </ol>
    </section>
                <section class="content">
                    <div class="row">
                        <!-- BEGIN BASIC ELEMENTS -->
                        <div class="col-md-12">
                            <div class="grid">
                                <div class="grid-header">
                                    <i class="fa fa-align-left"></i>
                                    <span class="grid-title">Laporan Produksi Harian</span>
                                    <div class="pull-right grid-tools">
                                        <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                                        <a data-widget="reload" title="Reload"><i class="fa fa-refresh"></i></a>
                                        <a data-widget="remove" title="Remove"><i class="fa fa-times"></i></a>
                                    </div>
                                </div>
                                <div class="grid-body">
                                    <form class="form-horizontal" method="post" action="<?php echo base_url()?>index.php/pes/report_daily_c/report_daily" >
                                        <div class="form-group">
                                            <div class="col-sm-offset-11">
                                                <div class="btn-group">
                                                    <button type="submit" name="start" class="btn btn-primary">Start </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Plant</label>
                                            <div class="col-sm-2">                                                
                                                <input type="text" name="plant" class="form-control" value="600" readonly>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Year</label>
                                            <div class="col-sm-2">
                                                <input type="text" name="year" class="form-control" value="2016" maxlength="4" required="true">
                                            </div>
                                        </div>

                                         <div class="form-group">
                                            <label class="col-sm-2 control-label">Period</label>
                                            <div class="col-sm-2">
                                                <input type="text" name="period" class="form-control" value="1" maxlength="2" required="true" onkeypress="validate(event)">
                                            </div>
                                        </div>
                                         <div class="form-group">
                                            <label class="col-sm-2 control-label">Part No.</label>
                                            <div class="col-sm-2">
                                                <input type="text" id="partno" name="partno" class="form-control" value="" autocomplete="off" >
                                            </div>
                                            <div class="col-sm-2">
                                                <button type="button" id="popup" style="margin-right: 20px" class="md-trigger btn btn-primary pull-left" data-modal="modal-1" >
                                                <i class="fa fa-list-alt"></i></button>
                                            </div>

                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Production Line</label>
                                            <div class="col-sm-2">
                                                <input type="text" id="prodline" name="prodline" class="form-control" value="" autocomplete="off" >
                                            </div>
                                            <div class="col-sm-2">
                                                <button type="button" id="popup1" style="margin-right: 20px" class="md-trigger btn btn-primary pull-left" data-modal="modal-2">
                                                <i class="fa fa-list-alt"></i></button>
                                            </div>
                                        </div>
                                    </form>
								
								</div>
                                   				
                            </div>
                        </div>
                        <!-- END BASIC ELEMENTS -->
                    </div>

                </section>
                <!-- END MAIN CONTENT -->
</aside>
            <!-- END CONTENT -->


<div class="md-modal md-effect-1" id="modal-1">
  <div class="md-content modal-content">
    <div class="modal-header">
      <h4 class="modal-title">PART NUMBER</h4>
    </div>
    <div class="modal-body">
      <table class="table">
        <?php
            for($i=1; $i<=10; $i+=2){
                echo ' <tr>
                          <td style="border:none !important"><input type="text" class="partno input-part-no-'.$i.' form-control"/></td>
                          <td style="border:none !important"><input type="text" class="partno input-part-no-'.($i+1).' form-control"/></td>
                      </tr>';
            }
        ?>
       
      </table>
    </div>
    <div class="modal-footer">
      <div class="btn-group">
        <button type="button" class="btn btn-primary md-close" data-dismiss="modal" id="partno-ok">OK</button>
      </div>
    </div>
  </div>
</div>

<div class="md-modal md-effect-1" id="modal-2">
  <div class="md-content modal-content">
    <div class="modal-header">
      <h4 class="modal-title">PRODUCTION LINE</h4>
    </div>
    <div class="modal-body">
      <table class="table">
        <?php
            for($i=1; $i<=10; $i+=2){
                echo ' <tr>
                          <td style="border:none !important"><input type="text" class="prodline input-prod-line-'.$i.' form-control"/></td>
                          <td style="border:none !important"><input type="text" class="prodline input-prod-line-'.($i+1).' form-control"/></td>
                      </tr>';
            }
        ?>
       
      </table>
    </div>
    <div class="modal-footer">
      <div class="btn-group">
        <button type="button" class="btn btn-primary md-close" data-dismiss="modal" id="prodline-ok">OK</button>
      </div>
    </div>
  </div>
</div>


<script type="text/javascript">
$('#popup').click(function(){
      $(".partno").each(function() {
        this.value = "";
      });

      var s = $('#partno').val().split(";");
      for(i = 1; i<=s.length; i++){
        if(s[i-1]!=""){
          $(".input-part-no-"+i).val(s[i-1]);
        }
      }
  });

$('#popup1').click(function(){
      $(".prodline").each(function() {
        this.value = "";
      });

      var s = $('#prodline').val().split(";");
      for(i = 1; i<=s.length; i++){
        if(s[i-1]!=""){
          $(".input-prod-line-"+i).val(s[i-1]);
        }
      }
  });

$('#partno-ok').click(function(){
    var s = "";
    $(".partno").each(function() {
      if(this.value!="") s = s+this.value+";";
    });
    var str = s.substring(s.length - 1);
    if(str == ";") s = s.substring(0, s.length - 1);
    $('#partno').val(s);
  });

$('#prodline-ok').click(function(){
    var s = "";
    $(".prodline").each(function() {
      if(this.value!="") s = s+this.value+";";
    });
    var str = s.substring(s.length - 1);
    if(str == ";") s = s.substring(0, s.length - 1);
    $('#prodline').val(s);
  });

function validate(evt) {
            if(evt.keyCode!=8) {
                var theEvent = evt || window.event;
                var key      = theEvent.keyCode || theEvent.which;
                    key      = String.fromCharCode( key );
                var regex    = /[0-9]|\./;

            if( !regex.test(key) ){
                theEvent.returnValue = false;
                if(theEvent.preventDefault) theEvent.preventDefault();
                }
            }
            }

</script>
