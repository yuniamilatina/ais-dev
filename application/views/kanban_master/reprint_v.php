<script>
$(document).ready(function() { 
$(window).keydown(function(event){
        if(event.keyCode == 13) {
          event.preventDefault();
          return false;
        }
});
// ajax order
$("#sid").focusin(function() {
var pno = $("#idorder").val();
            $.ajax({
                   type: 'POST',
                   url: '<?= base_url() ?>index.php/pes/kanban_master/getPart1',
                   data: 'pno=' + pno,
                   success: function(data) {
                       $("#pname").val(data);
                   }
            });
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/getBackno',
                data: 'pno=' + pno,
                success: function(data) {
                    $("#back_no").val(data);
                }
            });
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/getSupporder',
                data: 'pno=' + pno,
                success: function(data) {
                    $("#sid").html(data);
                }
            });
}); 

$("#sid").focusout(function() {
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/getStor2r',
                data: {sud: $('#sid').val(), idorder: $('#idorder').val()},
                success: function(data) {
                    $("#stor").val(data);
                }
            });
            $.ajax({
                url: "<?= base_url() ?>index.php/pes/kanban_master/getSuppName3",
                data: {sid: $('#sid').val()},type: 'POST',
                success: function(data) {
                    $("#sname").val(data);
                }
            });    
            $.ajax({
                url: '<?= base_url() ?>index.php/pes/kanban_master/qtyPerboxor',
                data: {sid: $('#sid').val(), idorder: $('#idorder').val()},
                type: 'POST',
                success: function(data) {
                    $("#qtyperbox").val(data);
                }
            });   
            $.ajax({
                url: '<?= base_url() ?>index.php/pes/kanban_master/keterangan2',
                data: {sid: $('#sid').val(), idorder: $('#idorder').val()},
                type: 'POST',
                success: function(data) {
                    $("#keterangan2").val(data);
                }
            }); 
            $.ajax({
                url: '<?= base_url() ?>index.php/pes/kanban_master/lastSerial2',
                data: {sid: $('#sid').val(), idorder: $('#idorder').val()},
                type: 'POST',
                success: function(data) {
                    $("#lastserial2").val(data);
                }
            });    
            $.ajax({
                url: '<?= base_url() ?>index.php/pes/kanban_master/boxTypeor',
                data: {sid: $('#sid').val(), idorder: $('#idorder').val()},
                type: 'POST',
                success: function(data) {
                    $("#boxtype").val(data);
                }
            });
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/spor',
                data: {sid: $('#sid').val(), idorder: $('#idorder').val()},
                success: function(data) {
                    $("#side").val(data);
                }
            });   
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/fromor',
                data: {sid: $('#sid').val(), idorder: $('#idorder').val()},
                success: function(data) {
                    $("#fromor").html(data);
          
                }
            });  
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/fromor',
                data: {sid: $('#sid').val(), idorder: $('#idorder').val()},
                success: function(data) {
                    $("#toor").html(data);
          
                }
            });     
});
$("#custom").change(function() {
            $.ajax({
                   type: 'POST',
                   url: '<?= base_url() ?>index.php/pes/kanban_master/cekSerialCustom',
                   data: {sid: $('#sid').val(), idorder: $('#idorder').val(),custom: $('#custom').val()},
                   success: function(data) {
                    $("#or").val(data);
                   }
            });
});
// end ajax order
// ajax proses
// begin change function
$("#prodver1").focusin(function() {
var pno = $("#idproses").val();
              $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/getPart1',
                data: 'pno=' + pno,
                success: function(data) {;
                    $("#pname1").val(data);
                }
              });
var pno = $("#idproses").val();
              $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/back_no1',
                data: 'pno=' + pno,
                success: function(data) {
                    $("#back_no1").val(data);;
                }
              });
var pno = $("#idproses").val();
              $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/getIntPv1',
                data: 'pno=' + pno,
                success: function(data) {
                    $("#prodver1").html(data);
                }
            });

});
// end change function
// begin focusout function
$("#prodver1").focusout(function() {
            $.ajax({ 
                url: "<?= base_url() ?>index.php/pes/kanban_master/boxType1",
                data: {prodver1: $('#prodver1').val(), idproses: $('#idproses').val()},
                type: 'POST',
                success: function(data) {
                    $("#boxtype1").val(data);
                }
            }); 
            $.ajax({ 
                url: "<?= base_url() ?>index.php/pes/kanban_master/getSelfpro1",
                data: {prodver1: $('#prodver1').val(), idproses: $('#idproses').val()},
                type: 'POST',
                success: function(data) {
                    $("#selfpro1").val(data);
                }
            }); 
var pno = $("#idproses").val();
            $.ajax({
                url: "<?= base_url() ?>index.php/pes/kanban_master/getnp1",
                data: {prodver1: $('#prodver1').val(), idproses: $('#idproses').val()},
                type: 'POST',
                success: function(data) {
                    $("#nextpro1").val(data);;
                }
            }); 
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/storNextpk',
                data: {prodver1: $('#prodver1').val(), idproses: $('#idproses').val()},
                success: function(data) {
                    $("#stornext1").val(data);
                }
            });  
            $.ajax({
                type: 'POST',
                url: "<?= base_url() ?>index.php/pes/kanban_master/ss1",
                data: {prodver1: $('#prodver1').val(), idproses: $('#idproses').val()},
                success: function(data) {
                    $("#storself1").val(data);
                }
            });
                $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/keterangan1',
                data: {prodver1: $('#prodver1').val(), idproses: $('#idproses').val()},
                success: function(data) {
                    $("#keterangan1").val(data);
                }
            }); 
              $.ajax({
                url: '<?= base_url() ?>index.php/pes/kanban_master/qtyPerbox1',
                data: {prodver1: $('#prodver1').val(), idproses: $('#idproses').val()},
                type: 'POST',
                success: function(data) {
                    $("#qtyperbox1").val(data);
                }
            }); 
            
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/side1',
                data: {prodver1: $('#prodver1').val(), idproses: $('#idproses').val()},
                success: function(data) {
                    $("#side1").val(data);
                }
            });  
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/lastSerial1',
                data: {prodver1: $('#prodver1').val(), idproses: $('#idproses').val()},
                success: function(data) {
                    $("#lastserial1").val(data);
          
                }
            });   
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/to',
                data: {prodver1: $('#prodver1').val(), idproses: $('#idproses').val()},
                success: function(data) {
                    $("#frompr").html(data);
          
                }
            });  
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/to',
                data: {prodver1: $('#prodver1').val(), idproses: $('#idproses').val()},
                success: function(data) {
                    $("#topr").html(data);
          
                }
            });  
});
$("#custom1").focusout(function() {
            $.ajax({
                   type: 'POST',
                   url: '<?= base_url() ?>index.php/pes/kanban_master/cekSerialCustompr',
                   data: {prodver1: $('#prodver1').val(), idproses: $('#idproses').val(),custom: $('#custom1').val()},
                   success: function(data) {
                        $("#pr").val(data);
                   }
            });
});
// endfocusoutfunction
// end ajax proses

// begin ajax suplyparts
$("#sid3").focusin(function() {
var pno = $("#idsupply").val();
                 $.ajax({
                   type: 'POST',
                   url: '<?= base_url() ?>index.php/pes/kanban_master/getPart1',
                   data: 'pno=' + pno,
                   success: function(data) {
                       $("#pname3").val(data);
                   }
              });
var pno = $("#idsupply").val();
              $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/getBackno',
                data: 'pno=' + pno,
                success: function(data) {
                    $("#backno3").val(data);
                }
            });

var pno = $("#idsupply").val();
              $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/getSupp',
                data: 'pno=' + pno,
                success: function(data) {
                    $("#sid3").html(data);
                }
            });

});
$("#sid3").focusout(function() {
            $.ajax({
                url: "<?= base_url() ?>index.php/pes/kanban_master/getSuppName",
                data: {sid3: $('#sid3').val()},type: 'POST',
                success: function(data) {
                    $("#sname3").val(data);
                }
            }); 
            $.ajax({
                url: '<?= base_url() ?>index.php/pes/kanban_master/keterangan4',
                data: {sid3: $('#sid3').val(), idsupply: $('#idsupply').val()},
                type: 'POST',
                success: function(data) {
                    $("#keterangan4").val(data);
                }
            }); 
            $.ajax({
                url: "<?= base_url() ?>index.php/pes/kanban_master/getStor",
                data: {sid3: $('#sid3').val(),idsupply: $('#idsupply').val()},
                type: 'POST',
                success: function(data) {
                    $("#stor3").val(data);
                }
            });
            $.ajax({
                url: '<?= base_url() ?>index.php/pes/kanban_master/qtyPerbox4',
                data: {sid3: $('#sid3').val(), idsupply: $('#idsupply').val()},
                type: 'POST',
                success: function(data) {
                    $("#qtyperbox4").val(data);
                }
            });   
            $.ajax({
                url: '<?= base_url() ?>index.php/pes/kanban_master/boxType4',
                data: {sid3: $('#sid3').val(), idsupply: $('#idsupply').val()},
                type: 'POST',
                success: function(data) {
                    $("#boxtype4").val(data);
                }
            });
            $.ajax({
                url: '<?= base_url() ?>index.php/pes/kanban_master/lastSerial4',
                data: {sid3: $('#sid3').val(), idsupply: $('#idsupply').val()},
                type: 'POST',
                success: function(data) {
                    $("#lastserial3").val(data);
                }
            });
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/side4',
                data: {sid3: $('#sid3').val(), idsupply: $('#idsupply').val()},
                success: function(data) {
                    $("#side4").val(data);
                }
            }); 
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/fromsp',
                data: {sid3: $('#sid3').val(), idsupply: $('#idsupply').val()},
                success: function(data) {
                    $("#fromsp").html(data);
          
                }
            });  
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/tosp',
                data: {sid3: $('#sid3').val(), idsupply: $('#idsupply').val()},
                success: function(data) {
                    $("#tosp").html(data);
          
                }
            });            
});
$("#custom2").change(function() {
            $.ajax({
                   type: 'POST',
                   url: '<?= base_url() ?>index.php/pes/kanban_master/cekSerialCustomsp',
                   data: {sid3: $('#sid3').val(), idsupply: $('#idsupply').val(),custom: $('#custom2').val()},
                   success: function(data) {
                    $("#sp").val(data);
                   }
            });
});
// end ajax supplyparts

// ajax pickup
// begin change function
$("#prodver3").focusin(function() {
var pno = $("#idpickup").val();
              $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/getPart1',
                data: 'pno=' + pno,
                success: function(data) {;
                    $("#pnamepu").val(data);
                }
              });
var pno = $("#idpickup").val();
              $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/back_no11',
                data: 'pno=' + pno,
                success: function(data) {
                    $("#back_no3").val(data);;
                }
              });
var pno = $("#idpickup").val();
              $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/getIntPv5',
                data: 'pno=' + pno,
                success: function(data) {
                    $("#prodver3").html(data);
                }
            });
              

});
// end change function
// begin focusout function
$("#prodver3").focusout(function() {
              $.ajax({ 
                url: "<?= base_url() ?>index.php/pes/kanban_master/getSelfpro3",
                data: {prodver3: $('#prodver3').val(), idpickup: $('#idpickup').val()},
                type: 'POST',
                success: function(data) {
                    $("#selfpro3").val(data);
                }
            });    
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/storNext2u',
                data: {pv3: $('#prodver3').val(), idpickup: $('#idpickup').val()},
                success: function(data) {
                    $("#stornext3").val(data);
                }
            });
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/storSelf1r',
                data: {prodver3: $('#prodver3').val(), idpickup: $('#idpickup').val()},
                success: function(data) {
                    $("#storself3").val(data);
                }
            });
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/getNextPro5pk',
                data: {prodver3: $('#prodver3').val(), idpickup: $('#idpickup').val()},
                success: function(data) {
                    $("#nextpro3").val(data);;
                }
            });
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/keterangan3',
                data: {prodver3: $('#prodver3').val(), idpickup: $('#idpickup').val()},
                success: function(data) {
                    $("#keterangan3").val(data);
                }
            }); 
            
              $.ajax({
                url: '<?= base_url() ?>index.php/pes/kanban_master/qtyPerbox3',
                data: {prodver3: $('#prodver3').val(), idpickup: $('#idpickup').val()},
                type: 'POST',
                success: function(data) {
                    $("#qtyperbox3").val(data);
                }
            }); 

              $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/boxType3',
                data: {prodver3: $('#prodver3').val(), idpickup: $('#idpickup').val()},
                success: function(data) {
                    $("#boxtype3").val(data);
                }
            });
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/side3',
                data: {prodver3: $('#prodver3').val(), idpickup: $('#idpickup').val()},
                success: function(data) {
                    $("#side3").val(data);
                }
            });  
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/lastSerial3',
                data: {prodver3: $('#prodver3').val(), idpickup: $('#idpickup').val()},
                success: function(data) {
                    $("#lastserial4").val(data);
                }
            });  
             $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/frompu',
                data: {prodver3: $('#prodver3').val(), idpickup: $('#idpickup').val()},
                success: function(data) {
                    $("#frompu").html(data);
          
                }
            });  
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/topu',
                data: {prodver3: $('#prodver3').val(), idpickup: $('#idpickup').val()},
                success: function(data) {
                    $("#topu").html(data);
          
                }
            });   

});
$("#custom4").change(function() {
            $.ajax({
                   type: 'POST',
                   url: '<?= base_url() ?>index.php/pes/kanban_master/cekSerialCustompu',
                   data: {prodver3: $('#prodver3').val(), idpickup: $('#idpickup').val(),custom: $('#custom4').val()},
                   success: function(data) {
                        $("#pu").val(data);
                   }
            });
});
// endfocusoutfunction

// ajax pickup passthrough
// begin change function
$("#stornext3p").focusin(function() {
var pno = $("#idpickupp").val();
              $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/getPart1',
                data: 'pno=' + pno,
                success: function(data) {;
                    $("#pnamepup").val(data);
                }
              });
var pno = $("#idpickupp").val();
              $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/back_nop',
                data: 'pno=' + pno,
                success: function(data) {
                    $("#back_no3p").val(data);;
                }
              });
              $.ajax({
                url: '<?= base_url() ?>index.php/pes/kanban_master/storSelfpp',
                data: {idpickup: $('#idpickupp').val()},type: 'POST',
                success: function(data) {
                    $("#storself3p").val(data);
                }
            });
            $.ajax({
                url: '<?= base_url() ?>index.php/pes/kanban_master/storNextpass',
                data: {idpickup: $('#idpickupp').val()},type: 'POST',
                success: function(data) {
                    $("#stornext3p").html(data);
                }
            });

});

$("#stornext3p").focusout(function() {
              $.ajax({
                url: '<?= base_url() ?>index.php/pes/kanban_master/getQtypass',
                data: {idpickup: $('#idpickupp').val(),slocto: $('#stornext3p').val()},
                type: 'POST',
                success: function(data) {
                    $("#qtyperbox3p").val(data);
                }
            }); 

            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/boxType3p',
                data: {idpickup: $('#idpickupp').val(),slocto: $('#stornext3p').val()},
                success: function(data) {
                    $("#boxtype3p").val(data);
                }
            });
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/side3p',
                data: {idpickup: $('#idpickupp').val(),slocto: $('#stornext3p').val()},
                success: function(data) {
                    $("#side3p").val(data);
                }
            });  
            
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/keterangan3p',
                data: {idpickup: $('#idpickupp').val(),slocto: $('#stornext3p').val()},
                success: function(data) {
                    $("#keterangan3p").val(data);
                }
            });  
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/lastSerial3p',
                data: {idpickup: $('#idpickupp').val(),slocto: $('#stornext3p').val()},
                success: function(data) {
                    $("#lastserial4p").val(data);
                }
            });  
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/frompup',
                data: {slocto: $('#stornext3p').val(), idpickup: $('#idpickupp').val()},
                success: function(data) {
                    $("#frompup").html(data);
          
                }
            });  
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>index.php/pes/kanban_master/frompup',
                data: {slocto: $('#stornext3p').val(), idpickup: $('#idpickupp').val()},
                success: function(data) {
                    $("#topup").html(data);
                }
            });  
});
$("#custom4p").change(function() {
            $.ajax({
                   type: 'POST',
                   url: '<?= base_url() ?>index.php/pes/kanban_master/cekSerialCustompup',
                   data: {slocfrom: $('#storself3p').val(), idpickup: $('#idpickupp').val(),custom: $('#custom4p').val()},
                   success: function(data) {
                        $("#pup").val(data);
                   }
            });
});
// endfocusoutfunction
// end ajax pickup passthrough
$('#myTab a').click(function(e) {
  e.preventDefault();
  $(this).tab('show');
});

// store the currently selected tab in the hash value
$("ul.nav-tabs > li > a").on("shown.bs.tab", function(e) {
  var id = $(e.target).attr("href").substr(1);
  window.location.hash = id;
});

// on load of the page: switch to the currently selected tab
var hash = window.location.hash;
$('#myTab a[href="' + hash + '"]').tab('show');
});
// end document ready

$(document).ready(function() {
// autocomplete
$('#idorder').autocomplete({
    source: "<?php echo site_url('pes/kanban_master/searchOldOr'); ?>",
    minLength:1 
});
$('#idsupply').autocomplete({
    source: "<?php echo site_url('pes/kanban_master/searchOldSp'); ?>",
    minLength:1 
});
$('#idproses').autocomplete({
    source: "<?php echo site_url('pes/kanban_master/searchOldPr'); ?>",
    minLength:1 
});
$('#idpickup').autocomplete({
    source: "<?php echo site_url('pes/kanban_master/searchOldPu'); ?>",
    minLength:1 
});
$('#idpickupp').autocomplete({
    source: "<?php echo site_url('pes/kanban_master/searchOldPup'); ?>",
    minLength:1 
});
}); //end document ready 
</script>
<style type="text/css">
  label{
  color:#000000;
  }
  input{
    color:#000000;
    //font-weight: bold;
  }
  button{
    color:#000000;
    //font-weight: bold;
  }
  li{
    color:#000000;
    //font-weight: bold;
  }
  select{
    color:#000000;
    //font-weight: bold;
  }
</style>
<aside class="right-side">

    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/'); ?>"><span>Home</span></a></li>
            <li><a href=""><strong>Kanban Master System</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
          <div class="col-md-12 text-center">
            <div class="grid">

              <div class="grid-header">
                <i class="fa fa-print"></i>
                        <span class="grid-title"><strong>REPRINT KANBAN</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                <div class="clearfix"></div>
                    <?php if($this->session->flashdata('message')<>''): ?>
                        <div class="alert alert-warning alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <?php echo $this->session->flashdata('message');?>
                        </div>
                       <br/>
                    <?php endif;?>
              </div>

              <div class="grid-body">
                <ul class="nav nav-tabs" id="myTab" >
                  <li class="active" ><a data-toggle="tab" href="#order_v">Order</a></li>
                  <li><a data-toggle="tab" href="#proses_v">Proses</a></li>
                  <li><a data-toggle="tab" href="#supplyparts_v">Supply Parts</a></li>
                  <li><a data-toggle="tab" href="#pickup_v">Pick Up</a></li>
                  <li><a data-toggle="tab" href="#pickupp_v">Pick Up Passthrough</a></li>
                </ul>

                <!-- begin tab content -->
                <div class="tab-content" style="align:left;">
                    <!-- begin tab order -->
                    <div id="order_v" class="tab-pane fade in active" >
                        <!-- baris ke 1 -->
                        <div class="row" style="margin-top:10px;margin-bottom:10px" >
                            <div class="col-sm-2" style="margin-left:0px;">
                            <label>Plant <select><option>600</option></select></label>
                            </div>      
                        </div>
                        <!-- end row 1  -->
                        <!-- baris ke 2-->
                        <div class="row" style="margin-bottom:15px;">
                            <div class= "col-sm-2" style="width:auto;margin-left:0px;"> 
                              <label style="margin-bottom:10px;">No. Part</label><br>
                              <label style="margin-bottom:10px;">Back No</label><br>
                              <label style="margin-bottom:10px;">Supplier</label><br>
                              <label style="margin-bottom:10px;">Storage</label><br>
                            </div>
                            <div class= "col-sm-2" style="width:1px;margin-left:0px;">
                                <label style="margin-bottom:10px;">:</label><br>
                                <label style="margin-bottom:10px;">:</label><br>
                                <label style="margin-bottom:10px;">:</label><br>
                                <label style="margin-bottom:10px;">:</label><br>
                            </div>
                            <div class= "col-sm-2" style="margin-left:0px;" >
                                <form method="post" action="" >
                                <div class="form-group" style="margin-bottom:0px">
                                    <input class="form-control" id ="idorder" name="idorder" style="height:28px;width:200px;" autofocus="autofocus" >
                                </div>
                                <div class="form-group" style="margin-top:5px;margin-bottom:5px">
                                    <input type="text" name="back_no" id="back_no"  style="background-color:#bfbfbf;height:25px;width:200px;" readonly="readonly">
                                </div>
                                <div class="form-group" style="margin-top:5px;margin-bottom:5px">
                                    <select class="form-control" id ="sid" name="sid" style="width:200px;height:28px;margin-bottom:5px" >
                                       <option></option>
                                   </select>
                                </div>
                                <div class="form-group" style="margin-top:5px;margin-bottom:5px">
                                    <input type="text" name="stor" id="stor"  style="background-color:#bfbfbf;height:28px;width:200px;" readonly="readonly">
                                </div>  
                            </div>
                            <div class="col-sm-3" style="margin-left:30px;">
                                <input type="text" name="pname" id="pname" value="" style="background-color:#bfbfbf;width:250px;height:28px;margin-left:30px;margin-bottom:40px;" readonly="readonly">
                                <input type="text" name="sname" id="sname" value="" style="background-color:#bfbfbf;width:250px;height:28px;margin-left:30px;" readonly="readonly">
                            </div>
                            <div class="col-sm-3" style="margin-left:30px;">
                                <label>Side</label>
                                <input type="text" name="side" id = "side" style="background-color:#bfbfbf;width:50px;height:25px;" readonly="readonly">
                            </div>
                        </div>
                        <!-- end row 2 -->
                        <!-- baris ke 3 -->
                        <div class="row" style="margin-bottom:10px;">
                            <div class="col-sm-3">
                                <label>Qty/Pack</label>
                                <input type="text" name="qtyperbox" id="qtyperbox" style="background-color:#bfbfbf;height:25px;" readonly="readonly"><br>
                            </div>
                            <div class="col-sm-3">
                                <label>Jenis Box</label>
                                <input type="text" name="boxtype" id="boxtype" style="background-color:#bfbfbf;width:80px;height:25px;" readonly="readonly">
                            </div> 
                            <label>Keterangan</label>         
                            <input type ="textarea" id="keterangan2" name = "keterangan2" readonly = "readonly" style="background-color:#bfbfbf;">
                        </div>
                        <!-- end row 3 -->

                        <!-- baris ke 4 -->     
                        <div class="row">
                            <div class="col-sm-8" style="border:1px solid">
                                <div class="row" style="text-align:left;margin-left:5px">
                                <label>Reprint Serial No.</label>
                                </div><br>
                            <div clas="row">
                              <div class="col-sm-2" style="text-align:left">  
                                <div class="radio" style="margin-bottom:10px;text-align:left">
                                <label><input type="radio" name="optradio" id="optradio1" value="A" class="optradio1">Sequence</label><br>
                                <label><input type="radio" name="optradio" id="optradio11" value="B" class="optradio1">Custom</label><br> 
                                </div>
                              <!--   <label>Print Qty</label> -->
                              </div> 
                              <div class="col-sm-2" style="text-align:left">
                                <select class="form-control" id="fromor" name="fromor" style="height:28px;width:100px;margin-bottom:5px">
                                    <option></option>
                                </select>
                                <input autocomplete="off" type="text" id="custom" name="custom" style="width:200px;" ><br>
                                <!-- <input type="number" name="printqty" id="printqty" min="1" max="1000" style="margin-top:3px;margin-bottom:3px;width:50px;height:25px;"> -->
                              </div>
                              <div class="col-sm-1" style="width:auto">
                                  <label>To</label>
                              </div>
                              <div class="col-sm-2" >
                                <select class="form-control" id="toor" name="toor" style="height:28px;width:100px">
                                    <option></option>
                                </select>
                              </div>
                            </div> 
                            </div>
                            <div class="col-sm-2" style="width:auto" >
                                <label>Last Serial No</label><input type="text" id ="lastserial2" name="lastserial2"  style="background-color:#bfbfbf;margin-left:10px;width:100px;height:25px;" readonly="readonly"><br>
                                <label>Print Date</label><input type="text" name="printdate2" id="printdate2" value="<?php echo date("Y-m-d")?>" style="background-color:#bfbfbf;margin-left:30px;width:100px;height:25px;" readonly="readonly">     
                            </div>
                            <input type="hidden" id="or" name="or" value="">
                        </div>
                        <!-- end row 4 -->
                        <!-- baris ke 5 -->
                        <div class="row" style="margin-top:10px;margin-bottom:10px;">
                        <div class="col-sm-6">
                            <button class="btn" name="reprintor" id="reprintor" value="#order_v" style="background-color:#66ccff;width:100px;height:30px" onclick="return validateFormOrd()" ><i class="icon-ok icon-white" ></i>PRINT</button>
                          <!-- <input type="submit" name="reprintor" id="reprintor" class="btn btn-info btn-md" value="PRINT"> -->
                        </div>
                        <div class="col-sm-6">
                          <a href="<?= base_url() ?>index.php/pes/kanban_master/reprint" class="btn" style="background-color:#66ccff;width:100px;height:30px;color:#000000" >Cancel</a>
                        </div>
                        </form>
                        </div>
                        <!-- end row 5 -->
                        <!-- end all row -->
                    </div>
                    <!-- end tab order -->

                    <!-- begin tab proses -->
                    <div id="proses_v" class="tab-pane fade">
                        <!-- baris ke 1 -->
                        <div class="row" style="margin-top:10px;margin-bottom:10px" >
                            <div class="col-sm-2" style="margin-left:0;">
                            <label>Plant <select><option>600</option></select></label>
                            </div>      
                        </div>
                        <!-- end row 1 -->

                        <!-- baris ke 2-->
                      <div class="row"  style="margin-bottom:20px;">
                        <div class= "col-sm-3" style="margin-left:0px;width:auto;text-align:left" >
                         <label style="margin-bottom:10px;">No. Part</label><br>
                         <label style="margin-bottom:10px;">Back No</label><br>
                         <label style="margin-bottom:10px;">Production version</label><br>
                         <label style="margin-bottom:10px;">Self Process</label><br>
                         <label style="margin-bottom:10px;">Storage(Self Process)</label><br>
                         <label style="margin-bottom:10px;">Next Process</label><br>
                         <label style="margin-bottom:10px;">Storage(Next Process)</label><br>
                        </div>
                        <div class= "col-sm-1" style="width:auto;margin-left:0px;">
                          <label style="margin-bottom:10px;">:</label><br>
                          <label style="margin-bottom:10px;">:</label><br>
                          <label style="margin-bottom:10px;">:</label><br>
                          <label style="margin-bottom:10px;">:</label><br>
                          <label style="margin-bottom:10px;">:</label><br>
                          <label style="margin-bottom:10px;">:</label><br>
                          <label style="margin-bottom:10px;">:</label><br>
                        </div>
                        <div class= "col-sm-2" style="width:auto;margin-left:0px;">
                          <form method="post" action="">
                            <input class="form-control" id ="idproses" name="idproses" style="height:28px;width:200px;margin-bottom:5px" autofocus="autofocus" >
                            <input type="text" name="back_no1" id="back_no1"  style="background-color:#bfbfbf;height:25px;width:200px;margin-bottom:5px" readonly="readonly"><br>
                            <select class="form-control" id ="prodver1" name="prodver1" style="height:28px;margin-bottom:5px" >
                             <option></option>
                            </select>
                            <input type="text" name="selfpro1" id="selfpro1"  style="background-color:#bfbfbf;height:25px;width:200px;margin-bottom:5px" readonly="readonly"><br>
                            <input type="text" name="storself1" id="storself1"  style="background-color:#bfbfbf;height:25px;width:200px;margin-bottom:5px" readonly="readonly"><br>
                            <input type="text" name="nextpro1" id="nextpro1"  style="background-color:#bfbfbf;height:25px;width:200px;margin-bottom:5px" readonly="readonly"><br>
                            <input type="text" name="stornext1" id="stornext1"  style="background-color:#bfbfbf;height:25px;width:200px;margin-bottom:5px" readonly="readonly">
                        </div>
                        <div class= "col-sm-3" style="width:auto;margin-left:0px;" >
                          <input type="text" name = "pname1" id = "pname1" style="background-color:#bfbfbf;width:250px;height:25px;margin-bottom:35px;" readonly="readonly"></br>
                        </div>
                        <div class="col-sm-3" style="margin-left:30px;">
                          <label>Side</label>
                          <input type="text" name="side1" id = "side1" style="background-color:#bfbfbf;width:50px;height:25px;" readonly="readonly">
                        </div>
                      </div>
                      <!-- end row 2 -->
                      <!-- baris ke 3 -->
                      <div class="row" style="margin-bottom:10px;">
                        <div class="col-sm-3">
                          <label>Qty/Pack</label>
                          <input type="text" id="qtyperbox1" name="qtyperbox1" style="background-color:#bfbfbf;height:25px;width:80px;" readonly="readonly"><br>
                        </div>
                        <div class="col-sm-3">
                          <label>Jenis Box</label>
                          <input type="text" name="boxtype1" id = "boxtype1" style="background-color:#bfbfbf;width:80px;height:25px;" readonly="readonly" ><br>
                        </div>  
                        <div>
                          <label>Keterangan </label>
                          <input type ="textarea" id="keterangan1" name = "keterangan1" readonly = "readonly" style="background-color:#bfbfbf;">
                        </div>  
                      </div><br>
                      <!-- end row 3 -->
                        <!-- baris ke 4 -->     
                        <div class="row">
                            <div class="col-sm-8" style="border:1px solid">
                            <div class="row" style="text-align:left;margin-left:5px">
                              <label>Reprint Serial No.</label>
                            </div><br>
                            <div clas="row">
                              <div class="col-sm-2" style="text-align:left">  
                                <div class="radio" style="margin-bottom:10px">
                                <label><input type="radio" name="optradio" id="optradio2" value="A">Sequence</label><br>
                                <label><input type="radio" name="optradio" id="optradio22" value="B">Custom</label><br> 
                                </div>
                        <!--         <label>Print Qty</label> -->
                              </div> 
                              <div class="col-sm-2" style="text-align:left">
                                <select class="form-control" id="frompr" name="frompr" style="height:28px;width:100px;margin-bottom:5px">
                                    <option></option>
                                </select>
                                <input autocomplete="off" type="text" id="custom1" name="custom1" style="width:200px;" ><br>
                                <!-- <input type="number" name="printqty1" id="printqty1" min="1" max="1000" style="margin-top:3px;margin-bottom:3px;width:50px;height:25px;"> -->
                              </div> 
                              <div class="col-sm-1" style="width:auto">
                                  <label>To</label>
                              </div>
                              <div class="col-sm-2">
                                <select class="form-control" id="topr" name="topr" style="height:28px;width:100px">
                                    <option></option>
                                </select>
                              </div>
                            </div>         
                            </div>
                          
                            <div class="col-sm-2" style="width:auto" >
                                <label>Last Serial No</label><input type="text" id ="lastserial1" name="lastserial1" style="background-color:#bfbfbf;margin-left:10px;width:100px;height:25px;" readonly="readonly"><br>
                                <label>Print Date</label><input type="text" name="printdate2" id="printdate2" value="<?php echo date("Y-m-d")?>" style="background-color:#bfbfbf;margin-left:30px;width:100px;height:25px;" readonly="readonly">     
                            </div>
                            <input type="hidden" id="pr" name="pr" value="">
                        </div>
                        <!-- end row 4 -->
                        <!-- baris ke 5 -->
                        <div class="row" style="margin-top:10px;margin-bottom:10px;">
                            <div class="col-sm-6">
                                <button class="btn" name="reprintpr" id="reprintpr" value="#proses_v" style="background-color:#66ccff;width:100px;height:30px" onclick="return validateFormProc()" ><i class="icon-ok icon-white" ></i>PRINT</button>
                            </div>
                            <div class="col-sm-6">
                              <a href="<?= base_url() ?>index.php/pes/kanban_master/reprint" class="btn" style="background-color:#66ccff;width:100px;height:30px;color:#000000" >Cancel</a>
                            </div>
                        </div>
                        </form>
                        <!-- end row 5 -->
                    </div>
                    <!-- end tab proses -->

                    <!-- begin tab supply parts -->
                    <div id="supplyparts_v" class="tab-pane fade">
                        <!-- baris ke 1 -->
                        <div class="row" style="margin-top:10px;margin-bottom:10px" >
                            <div class="col-sm-2">
                                <label>Plant <select><option>600</option></select></label>
                            </div>      
                        </div>
                        <!-- end row 1 -->
                        <!-- baris ke 2-->
                        <div class="row" style="margin-bottom:15px;">
                            <div class= "col-sm-2" style="width:auto;margin-left:0px;"> 
                              <label style="margin-bottom:10px;">No. Part</label><br>
                              <label style="margin-bottom:10px;">Back No</label><br>
                              <label style="margin-bottom:10px;">Supplier</label><br>
                              <label style="margin-bottom:10px;">Storage</label><br>
                            </div>
                            <div class= "col-sm-2" style="width:1px;margin-left:0px;">
                              <label style="margin-bottom:10px;">:</label><br>
                              <label style="margin-bottom:10px;">:</label><br>
                              <label style="margin-bottom:10px;">:</label><br>
                              <label style="margin-bottom:10px;">:</label><br>
                            </div>
                            <div class= "col-sm-2" style="margin-left:0px;" >
                            <form  method="post" action="" >
                              <div class="form-group" style="margin-bottom:0px">
                                  <input class="form-control" id ="idsupply" name="idsupply" style="height:28px;width:200px;" autofocus="autofocus" >
                              </div>
                              <div class="form-group" style="margin-top:5px;margin-bottom:5px">
                                <input type="text" name="backno3" id="backno3"  style="background-color:#bfbfbf;height:25px;width:200px;" readonly="readonly">
                            </div>
                            <div class="form-group" style="margin-top:5px;margin-bottom:5px">
                                <select class="form-control" name="sid3" id="sid3" style="height:28px;width:200px;margin-bottom:5px;">
                                    <option></option>
                                </select> 
                            </div>
                            <div class="form-group" style="margin-top:5px;margin-bottom:5px">
                                <input type="text" name="stor3" id="stor3" style="background-color:#bfbfbf;height:28px;width:200px;margin-bottom:5px;"readonly="readonly">
                            </div>  
                            </div>
                            <div class="col-sm-3" style="margin-left:30px;">
                                <input type="text" name="pname3" id="pname3" value="" style="background-color:#bfbfbf;width:250px;height:25px;margin-left:30px;margin-bottom:35px;" readonly="readonly">
                                <input type="text" name="sname3" id="sname3" value="" style="background-color:#bfbfbf;width:250px;height:25px;margin-left:30px;" readonly="readonly">
                            </div>
                            <div class="col-sm-2" >
                                <label style="margin-left:170px;">Side</label>
                            </div>
                            <div class="col-sm-2" style="margin-left:0px;">  
                                <input type="text" name="side4" id="side4" style="background-color:#bfbfbf;width:80px;height:25px;" readonly="readonly" >
                            </div>

                        </div>
                        <!-- end row 2 -->
                        <!-- baris ke 3 -->
                        <div class="row" style="margin-bottom:10px;">
                            <div class="col-sm-3">
                              <label>Qty/Pack</label>
                              <input type="text" name="qtyperbox4" id="qtyperbox4" style="background-color:#bfbfbf;height:25px;width:80px;" readonly="readonly"><br>
                          </div>
                          <div class="col-sm-3">
                              <label>Jenis Box</label>
                              <input type="text" name="boxtype4" id="boxtype4" style="background-color:#bfbfbf;width:80px;height:25px;" readonly="readonly" ><br>
                          </div> 
                          <div>
                              <label>Keterangan </label>
                              <input type ="textarea" id="keterangan4" name = "keterangan4" style="background-color:#bfbfbf;width:80px;height:25px;" readonly="readonly">
                          </div> 
                        </div><br>
                        <!-- end row 3 -->
                        <!-- baris ke 4 -->     
                        <div class="row">
                            <div class="col-sm-8" style="border:1px solid">
                            <div class="row" style="text-align:left;margin-left:5px">
                              <label>Reprint Serial No.</label>
                            </div><br>
                            <div clas="row">
                                <div class="col-sm-2" style="text-align:left">  
                                <div class="radio" style="margin-bottom:10px">
                                    <label><input type="radio" name="optradio" id="optradio3" value="A">Sequence</label><br>
                                    <label><input type="radio" name="optradio" id="optradio33" value="B">Custom</label><br> 
                                </div>
                                <!-- <label>Print Qty</label> -->
                                </div> 
                                <div class="col-sm-2" style="text-align:left">
                                <select class="form-control" id="fromsp" name="fromsp" style="height:28px;width:100px;margin-bottom:5px">
                                    <option></option>
                                </select>
                                <input autocomplete="off" type="text" id="custom2" name="custom2" style="width:200px;" ><br>
                                <!-- <input type="number" name="printqty2" id="printqty2" min="1" max="1000" style="margin-top:3px;margin-bottom:3px;width:50px;height:25px;"> -->
                                </div> 
                                <div class="col-sm-1" style="width:auto">
                                    <label>To</label>
                                </div>
                                <div class="col-sm-2">
                                <select class="form-control" id="tosp" name="tosp" style="height:28px;width:100px">
                                <option></option>
                                </select>
                                </div>
                            </div>         
                            </div>
                            <div class="col-sm-2" style="width:auto" >
                                <label>Last Serial No</label><input type="text" id ="lastserial3" name="lastserial3" style="background-color:#bfbfbf;margin-left:10px;width:100px;height:25px;" readonly="readonly"><br>
                                <label>Print Date</label><input type="text" name="printdate2" id="printdate2" value="<?php echo date("Y-m-d")?>" style="background-color:#bfbfbf;margin-left:30px;width:100px;height:25px;" readonly="readonly">     
                            </div>
                            <input type="hidden" id="sp" name="sp" value="">
                        </div>
                        <!-- end row 4 -->
                        <!-- baris ke 5 -->
                        <div class="row" style="margin-top:10px;margin-bottom:10px;">
                            <div class="col-sm-6">
                                <button class="btn" id="reprintsp" name="reprintsp" value="1" style="background-color:#66ccff;width:100px;height:30px" onclick="return validateFormSupp()" ><i class="icon-ok icon-white" ></i>PRINT</button>
                            </div>
                            <div class="col-sm-6">
                            <a href="<?= base_url() ?>index.php/pes/kanban_master/reprint" class="btn" style="background-color:#66ccff;width:100px;height:30px;color:#000000" >Cancel</a>
                            </div>
                        </div>
                        </form>
                        <!-- end row 5 -->
                    </div>
                    <!-- end tab supply parts -->

                    <!-- begin tab pickup -->
                    <div id="pickup_v" class="tab-pane fade">
                        <!-- baris ke 1 -->
                        <div class="row" style="margin-top:10px;margin-bottom:10px" >
                            <div class="col-sm-2" style="margin-left:0;">
                            <label>Plant <select><option>600</option></select></label>
                            </div>      
                        </div>
                        <!-- end row 1 -->
                        <!-- baris ke 2-->
                      <div class="row"  style="margin-bottom:20px;">
                        <div class= "col-sm-3" style="margin-left:0px;width:auto;text-align:left" >
                         <label style="margin-bottom:10px;">No. Part</label><br>
                         <label style="margin-bottom:10px;">Back No</label><br>
                         <label style="margin-bottom:10px;">Production version</label><br>
                         <label style="margin-bottom:10px;">Self Process</label><br>
                         <label style="margin-bottom:10px;">Storage(Self Process)</label><br>
                         <label style="margin-bottom:10px;">Next Process</label><br>
                         <label style="margin-bottom:10px;">Storage(Next Process)</label><br>
                        </div>
                        <div class= "col-sm-1" style="width:auto;margin-left:0px;">
                          <label style="margin-bottom:10px;">:</label><br>
                          <label style="margin-bottom:10px;">:</label><br>
                          <label style="margin-bottom:10px;">:</label><br>
                          <label style="margin-bottom:10px;">:</label><br>
                          <label style="margin-bottom:10px;">:</label><br>
                          <label style="margin-bottom:10px;">:</label><br>
                          <label style="margin-bottom:10px;">:</label><br>
                        </div>
                        <div class= "col-sm-2" style="width:auto;margin-left:0px;">
                          <form method="post" action="">
                            <input class="form-control" id ="idpickup" name="idpickup" style="height:28px;width:200px;margin-bottom:5px" autofocus="autofocus" >
                            <input type="text" name="back_no3" id="back_no3"  style="background-color:#bfbfbf;height:25px;width:200px;margin-bottom:5px" readonly="readonly"><br>
                            <select class="form-control" id ="prodver3" name="prodver3" style="height:28px;margin-bottom:5px" >
                             <option></option>
                            </select>
                            <input type="text" name="selfpro3" id="selfpro3"  style="background-color:#bfbfbf;height:25px;width:200px;margin-bottom:5px" readonly="readonly"><br>
                            <input type="text" name="storself3" id="storself3"  style="background-color:#bfbfbf;height:25px;width:200px;margin-bottom:5px" readonly="readonly"><br>
                            <input type="text" name="nextpro3" id="nextpro3"  style="background-color:#bfbfbf;height:25px;width:200px;margin-bottom:5px" readonly="readonly"><br>
                            <input type="text" name="stornext3" id="stornext3"  style="background-color:#bfbfbf;height:25px;width:200px;margin-bottom:5px" readonly="readonly">
                        </div>
                        <div class= "col-sm-3" style="width:auto;margin-left:0px;" >
                          <input type="text" name = "pnamepu" id = "pnamepu" value ="" style="background-color:#bfbfbf;width:250px;height:25px;margin-bottom:35px;" readonly="readonly"></br>
                        </div>
                        <div class="col-sm-3" style="margin-left:30px;">
                          <label>Side</label>
                          <input type="text" name="side3" id = "side3" style="background-color:#bfbfbf;width:50px;height:25px;" readonly="readonly">
                        </div>
                      </div>
                      <!-- end row 2 -->
                      <!-- baris ke 3 -->
                      <div class="row" style="margin-bottom:10px;">
                        <div class="col-sm-3">
                          <label>Qty/Pack</label>
                          <input type="text" name="qtyperbox3" id="qtyperbox3" style="background-color:#bfbfbf;height:25px;width:80px;" readonly="readonly"><br>
                        </div>
                        <div class="col-sm-3">
                          <label>Jenis Box</label>
                          <input type="text" name="boxtype3" id = "boxtype3" style="background-color:#bfbfbf;width:80px;height:25px;" readonly="readonly" ><br>
                        </div> 
                        <div>
                          <label>Keterangan </label>
                          <input type ="textarea" id="keterangan3" name = "keterangan3"  style="background-color:#bfbfbf;width:80px;height:25px;" readonly="readonly">
                        </div>   
                      </div><br>
                      <!-- end row 3 -->
                        <!-- baris ke 4 -->     
                        <div class="row">
                            <div class="col-sm-8" style="border:1px solid">
                            <div class="row" style="text-align:left;margin-left:5px">
                              <label>Reprint Serial No.</label>
                            </div><br>
                            <div clas="row">
                                <div class="col-sm-2" style="text-align:left">  
                                <div class="radio" style="margin-bottom:10px">
                                <label><input type="radio" name="optradio" id="optradio4" value="A">Sequence</label><br>
                                <label><input type="radio" name="optradio" id="optradio44" value="B">Custom</label><br> 
                                </div>
                                <!-- <label>Print Qty</label> -->
                                </div> 
                                <div class="col-sm-2" style="text-align:left">
                                <select class="form-control" id="frompu" name="frompu" style="height:28px;width:100px;margin-bottom:5px">
                                    <option></option>
                                </select>
                                <input autocomplete="off" type="text" id="custom4" name="custom4" style="width:200px;" ><br>
                                <!-- <input type="number" name="printqty3" id="printqty3" min="1" max="1000" style="margin-top:3px;margin-bottom:3px;width:50px;height:25px;"> -->
                                </div> 

                                <div class="col-sm-1" style="width:auto">
                                  <label>To</label>
                                </div>

                                <div class="col-sm-2">
                                    <select class="form-control" id="topu" name="topu" style="height:28px;width:100px">
                                    <option></option>
                                    </select>
                                </div> 
                            </div>
                            </div>
                            <div class="col-sm-2" style="width:auto" >
                                <label>Last Serial No</label><input type="text" id ="lastserial4" name="lastserial4" style="background-color:#bfbfbf;margin-left:10px;width:100px;height:25px;" readonly="readonly"><br>
                                <label>Print Date</label><input type="text" name="printdate2" id="printdate2" value="<?php echo date("Y-m-d")?>" style="background-color:#bfbfbf;margin-left:30px;width:100px;height:25px;" readonly="readonly">     
                            </div>
                            <input type="hidden" id="pu" name="pu" value="">
                        </div>
                        <!-- end row 4 -->
                        <!-- baris ke 5 -->
                        <div class="row" style="margin-top:10px;margin-bottom:10px;">
                        <div class="col-sm-6">
                          <button class="btn" name="reprintpu" id="reprintpu" value="#pickup_v" style="background-color:#66ccff;width:100px;height:30px" onclick="return validateFormPick()" ><i class="icon-ok icon-white" ></i>PRINT</button>
                        </div>
                        <div class="col-sm-6">
                          <a href="<?= base_url() ?>index.php/pes/kanban_master/reprint" class="btn" style="background-color:#66ccff;width:100px;height:30px;color:#000000" >Cancel</a>
                        </div>
                        </div>
                        </form>
                        <!-- end row 5 -->
                    </div>
                    <!-- end tab pickup -->

                    <!-- begin tab pickup passthrough -->
                    <div id="pickupp_v" class="tab-pane fade">
                        <!-- baris ke 1 -->
                        <div class="row" style="margin-top:10px;margin-bottom:10px" >
                            <div class="col-sm-2" style="margin-left:0;">
                            <label>Plant <select><option>600</option></select></label>
                            </div>      
                        </div>
                        <!-- end row 1 -->
                        <!-- baris ke 2-->
                      <div class="row"  style="margin-bottom:20px;">
                        <div class= "col-sm-3" style="margin-left:0px;width:auto;text-align:left" >
                         <label style="margin-bottom:10px;">No. Part</label><br>
                         <label style="margin-bottom:10px;">Back No</label><br>
                         <label style="margin-bottom:10px;">Storage Location From</label><br>
                         <label style="margin-bottom:10px;">Storage Location To</label><br>
                        </div>
                        <div class= "col-sm-1" style="width:auto;margin-left:0px;">
                          <label style="margin-bottom:10px;">:</label><br>
                          <label style="margin-bottom:10px;">:</label><br>
                          <label style="margin-bottom:10px;">:</label><br>
                          <label style="margin-bottom:10px;">:</label><br>
                        </div>
                        <div class= "col-sm-2" style="width:auto;margin-left:0px;">
                          <form method="post" action="">
                            <input class="form-control" id ="idpickupp" name="idpickupp" style="height:28px;width:200px;margin-bottom:5px" autofocus="autofocus" >
                            <input type="text" name="back_no3p" id="back_no3p"  style="background-color:#bfbfbf;height:25px;width:200px;margin-bottom:5px" readonly="readonly"><br>
                            <input class="form-control" name="storself3p" id="storself3p" style="background-color:#bfbfbf;height:28px;margin-bottom:5px" readonly="readonly">
                            <select class="form-control" name="stornext3p" id="stornext3p" style="height:28px;margin-bottom:5px" >
                             <option></option>
                            </select>
                        </div>
                        <div class= "col-sm-3" style="width:auto;margin-left:0px;" >
                          <input type="text" name = "pnamepup" id = "pnamepup" value ="" style="background-color:#bfbfbf;width:250px;height:25px;margin-bottom:35px;" readonly="readonly"></br>
                        </div>
                        <div class="col-sm-3" style="margin-left:30px;">
                          <label>Side</label>
                          <input type="text" name="side3p" id = "side3p" style="background-color:#bfbfbf;width:50px;height:25px;" readonly="readonly">
                        </div>
                      </div>
                      <!-- end row 2 -->
                      <!-- baris ke 3 -->
                      <div class="row" style="margin-bottom:10px;">
                        <div class="col-sm-3">
                          <label>Qty/Pack</label>
                          <input type="text" name="qtyperbox3p" id="qtyperbox3p" style="background-color:#bfbfbf;height:25px;width:80px;" readonly="readonly"><br>
                        </div>
                        <div class="col-sm-3">
                          <label>Jenis Box</label>
                          <input type="text" name="boxtype3p" id = "boxtype3p" style="background-color:#bfbfbf;width:80px;height:25px;" readonly="readonly" ><br>
                        </div> 
                        <div>
                          <label>Keterangan </label>
                          <input type ="textarea" id="keterangan3p" name = "keterangan3p"  style="background-color:#bfbfbf;width:80px;height:25px;" readonly="readonly">
                        </div>   
                      </div><br>
                      <!-- end row 3 -->
                        <!-- baris ke 4 -->     
                        <div class="row">
                            <div class="col-sm-8" style="border:1px solid">
                            <div class="row" style="text-align:left;margin-left:5px">
                              <label>Reprint Serial No.</label>
                            </div><br>
                            <div clas="row">
                                <div class="col-sm-2" style="text-align:left">  
                                <div class="radio" style="margin-bottom:10px">
                                <label><input type="radio" name="optradio" id="optradio5" value="A">Sequence</label><br>
                                <label><input type="radio" name="optradio" id="optradio55" value="B">Custom</label><br> 
                                </div>
                                <!-- <label>Print Qty</label> -->
                                </div> 
                                <div class="col-sm-2" style="text-align:left">
                                <select class="form-control" id="frompup" name="frompup" style="height:28px;width:100px;margin-bottom:5px">
                                    <option></option>
                                </select>
                                <input autocomplete="off" type="text" id="custom4p" name="custom4p" style="width:200px;" ><br>
                                <!-- <input type="number" name="printqty4" id="printqty4" min="1" max="1000" style="margin-top:3px;margin-bottom:3px;width:50px;height:25px;"> -->
                                </div> 
                                <div class="col-sm-1" style="width:auto">
                                  <label>To</label>
                                </div>
                                <div class="col-sm-2">
                                    <select class="form-control" id="topup" name="topup" style="height:28px;width:100px">
                                    <option></option>
                                    </select>
                                </div> 
                            </div>
                            </div>
                            <div class="col-sm-2" style="width:auto" >
                                <label>Last Serial No</label><input type="text" id ="lastserial4p" name="lastserial4p" style="background-color:#bfbfbf;margin-left:10px;width:100px;height:25px;" readonly="readonly"><br>
                                <label>Print Date</label><input type="text" name="printdate2" id="printdate2" value="<?php echo date("Y-m-d")?>" style="background-color:#bfbfbf;margin-left:30px;width:100px;height:25px;" readonly="readonly">     
                            </div>
                            <input type="hidden" id="pup" name="pup" value="">
                        </div>
                        <!-- end row 4 -->
                        <!-- baris ke 5 -->
                        <div class="row" style="margin-top:10px;margin-bottom:10px;">
                            <div class="col-sm-6">
                                <button class="btn" name="reprintpup" id="reprintpup" value="#pickupp_v" style="background-color:#66ccff;width:100px;height:30px" onclick="return validateFormPass()" ><i class="icon-ok icon-white" ></i>PRINT</button>
                            </div>
                            <div class="col-sm-6">
                                <a href="<?= base_url() ?>index.php/pes/kanban_master/reprint" class="btn" style="background-color:#66ccff;width:100px;height:30px;color:#000000" >Cancel</a>
                            </div>
                        </div>
                        </form>
                        <!-- end row 5 -->
                    </div>
                    <!-- end tab pickup passthrough-->

                </div>
                <!-- end tab content -->

              </div>
              <!-- end grid body -->
            </div>
              <!-- end grid class  -->
          </div>
        </div>  
    </section>
</aside>

<script>
function validateFormOrd() {
            var status=false;
            var partno = document.getElementById('idorder').value;
            var or = document.getElementById('or').value;
            var from = document.getElementById('fromor').value;
            var to = document.getElementById('toor').value;
            // var printqty = document.getElementById('printqty').value;
            var sid = document.getElementById('sid').value;
            var custom = document.getElementById('custom').value;
            var check=document.getElementById('optradio1').checked;
            var check1=document.getElementById('optradio11').checked;
            
            if(partno==""){
                alert("Silahkan masukkan data kanban yang akan di print");
                status = false;
            }
            // else if (printqty=="") {
            //     alert("Silahkan masukkan jumlah kanban yang akan di print");
            //     status = false;
            // }
            else if (sid=="") {
                alert("Silahkan pilih supplier id");
                status = false;
            }else if (check=='' && check1=='') {
                alert("Pilih nomor serial yang akan di-reprint");
                status = false;
            }else if(check==false && check1==true){
                if (custom=='') {
                    alert("Masukkan nomor serial yang akan di-reprint");
                    status = false;
                }else if (or!=1) {
                    alert("Nomor Serial yang anda masukkan salah");
                    status = false;
                }else{
                    var r = confirm("Print kanban ?");
                    if (r==true) {
                        status= true;
                    }else{
                        status=false;
                    }
                }
            }else if(check==true && check1==false){
                if (from=='' || to=='') {
                    alert("Kanban belum pernah di print");
                    status = false;
                }else{
                    var r = confirm("Print kanban ?");
                    if (r==true) {
                        status= true;
                    }else{
                        status=false;
                    }
                }
            } else{
              var r = confirm("Print kanban ?");
              if (r==true) {
                status= true;
              }else{
                status=false;
              }
              
            }
                
            return status;

}
function validateFormProc() {
            var status=false;
            var partno = document.getElementById('idproses').value;
            var pr = document.getElementById('pr').value;
            var from = document.getElementById('frompr').value;
            var to = document.getElementById('topr').value;
            // var printqty = document.getElementById('printqty1').value;
            var prodver = document.getElementById('prodver1').value;
            var custom = document.getElementById('custom1').value;
            var check=document.getElementById('optradio2').checked;
            var check1=document.getElementById('optradio22').checked;
            
            if(partno==""){
                alert("Silahkan masukkan data kanban yang akan di print");
                status = false;
            }
            // else if (printqty=="") {
            //     alert("Silahkan masukkan jumlah kanban yang akan di print");
            //     status = false;
            // }
            else if (prodver=="") {
                alert("Silahkan pilih production version");
                status = false;
            }else if (check=='' && check1=='') {
                alert("Pilih nomor serial yang akan di-reprint");
                status = false;
            }else if(check==false && check1==true){
                if (custom=='') {
                    alert("Masukkan nomor serial yang akan di-reprint");
                    status = false;
                }else if (pr!=1) {
                    alert("Nomor Serial yang anda masukkan salah");
                    status = false;
                }else{
                    var r = confirm("Print kanban ?");
                    if (r==true) {
                        status= true;
                    }else{
                        status=false;
                    }
                }
            }else if(check==true && check1==false){
                if (from=='' || to=='') {
                    alert("Kanban belum pernah di print");
                    status = false;
                }else{
                    var r = confirm("Print kanban ?");
                    if (r==true) {
                        status= true;
                    }else{
                        status=false;
                    }
                }
            }else{
              var r = confirm("Print kanban ?");
              if (r==true) {
                status= true;
              }else{
                status=false;
              }
              
            }
                
            return status;

}
function validateFormSupp() {
            var status=false;
            var partno = document.getElementById('idsupply').value;
            var sp = document.getElementById('sp').value;
            var from = document.getElementById('fromsp').value;
            var to = document.getElementById('tosp').value;
            // var printqty = document.getElementById('printqty2').value;
            var sid = document.getElementById('sid3').value;
            var custom = document.getElementById('custom2').value;
            var check=document.getElementById('optradio3').checked;
            var check1=document.getElementById('optradio33').checked;
            
            if(partno==""){
                alert("Silahkan masukkan data kanban yang akan di print");
                status = false;
            }
            // else if (printqty=="") {
            //     alert("Silahkan masukkan jumlah kanban yang akan di print");
            //     status = false;
            // }
            else if (sid=="") {
                alert("Silahkan pilih supplier id");
                status = false;
            }else if (check=='' && check1=='') {
                alert("Pilih nomor serial yang akan di-reprint");
                status = false;
            }else if(check==false && check1==true){
                if (custom=='') {
                    alert("Masukkan nomor serial yang akan di-reprint");
                    status = false;
                }else if (sp!=1) {
                    alert("Nomor Serial yang anda masukkan salah");
                    status = false;
                }else{
                    var r = confirm("Print kanban ?");
                    if (r==true) {
                        status= true;
                    }else{
                        status=false;
                    }
                }
            }else if(check==true && check1==false){
                if (from=='' || to=='') {
                    alert("Kanban belum pernah di print");
                    status = false;
                }else{
                    var r = confirm("Print kanban ?");
                    if (r==true) {
                        status= true;
                    }else{
                        status=false;
                    }
                }
            }else{
              var r = confirm("Print kanban ?");
              if (r==true) {
                status= true;
              }else{
                status=false;
              }
              
            }
                
            return status;

}  

function validateFormPick() {
            var status=false;
            var partno = document.getElementById('idpickup').value;
            var pu = document.getElementById('pu').value;
            var from = document.getElementById('frompu').value;
            var to = document.getElementById('topu').value;
            // var printqty = document.getElementById('printqty3').value;
            var prodver = document.getElementById('prodver3').value;
            var custom = document.getElementById('custom4').value;
            var check1 = document.getElementById('optradio44').checked;
            var check=document.getElementById('optradio4').checked;
            
            if(partno==""){
                alert("Silahkan masukkan data kanban yang akan di print");
                status = false;
            }
            // else if (printqty=="") {
            //     alert("Silahkan masukkan jumlah kanban yang akan di print");
            //     status = false;
            // }
            else if (prodver=="") {
                alert("Silahkan pilih production version");
                status = false;
            }else if (check=='' && check1=='') {
                alert("Pilih nomor serial yang akan di-reprint");
                status = false;
            }else if(check==false && check1==true){
                if (custom=='') {
                    alert("Masukkan nomor serial yang akan di-reprint");
                    status = false;
                }else if (pu!=1) {
                    alert("Nomor Serial yang anda masukkan salah");
                    status = false;
                }else{
                    var r = confirm("Print kanban ?");
                    if (r==true) {
                        status= true;
                    }else{
                        status=false;
                    }
                }
            }else if(check==true && check1==false){
                if (from=='' || to=='') {
                    alert("Kanban belum pernah di print");
                    status = false;
                }else{
                    var r = confirm("Print kanban ?");
                    if (r==true) {
                        status= true;
                    }else{
                        status=false;
                    }
                }
            }else{
              var r = confirm("Print kanban ?");
              if (r==true) {
                status= true;
              }else{
                status=false;
              }
              
            }
                
            return status;

}

function validateFormPass() {
    var status=false;
    var partno = document.getElementById('idpickupp').value;
    var pup = document.getElementById('pup').value;
    var from = document.getElementById('frompup').value;
    var to = document.getElementById('topup').value;
    // var printqty = document.getElementById('printqty4').value;
    var slocfrom = document.getElementById('stornext3p').value;
    var custom = document.getElementById('custom4p').value;
    var check=document.getElementById('optradio5').checked;
    var check1=document.getElementById('optradio55').checked;
            
            if(partno==""){
                alert("Silahkan masukkan data kanban yang akan di print");
                status = false;
            }
            // else if (printqty=="") {
            //     alert("Silahkan masukkan jumlah kanban yang akan di print");
            //     status = false;
            // }
            else if (slocfrom=="") {
                alert("Silahkan pilih storage location to");
                status = false;
            }else if (check=='' && check1=='') {
                alert("Pilih nomor serial yang akan di-reprint");
                status = false;
            }else if(check==false && check1==true){
                if (custom=='') {
                    alert("Masukkan nomor serial yang akan di-reprint");
                    status = false;
                }else if (pup!=1) {
                    alert("Nomor Serial yang anda masukkan salah");
                    status = false;
                }else{
                    var r = confirm("Print kanban ?");
                    if (r==true) {
                        status= true;
                    }else{
                        status=false;
                    }
                }
            }else if(check==true && check1==false){
                if (from=='' || to=='') {
                    alert("Kanban belum pernah di print");
                    status = false;
                }else{
                    var r = confirm("Print kanban ?");
                    if (r==true) {
                        status= true;
                    }else{
                        status=false;
                    }
                }
            }else{
              var r = confirm("Print kanban ?");
              if (r==true) {
                status= true;
              }else{
                status=false;
              }
              
            }
                
            return status;

}
</script>
                
  