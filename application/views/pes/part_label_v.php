<script>
    setTimeout(function () {
        document.getElementById("hide-sub-menus").click();
    }, 15);
</script>

<style type="text/css">
    th, td { white-space: nowrap; }
    div.dataTables_wrapper {
        margin: 0 auto;
    }
    #table-luar{
        font-size: 12px;
    }
    #filter { 
        border-spacing: 10px;
        border-collapse: separate;
    }
    .td-fixed{
        width: 30px;
    }
    .td-no{
        width: 10px;
    }
    .ddl{
        width: 100px;
        height: 30px;
    }
    .ddl2{
        width: 180px;
        height: 30px;
    }
</style>

<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/') ?>"><span>Home</span></a></li>
            <li> <a href="#"><strong>MANAGE PART LABEL</strong></a></li>
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
                        <i class="fa fa-th"></i>
                        <span class="grid-title"><strong>MANAGE PART LABEL</strong></span>
                        <div class="pull-right grid-tools">
                            <a href="<?php echo base_url('index.php/pes/part_label_c/create_part_label/' .  $work_center) ?>" class="btn btn-default" data-toggle="tooltip" data-placement="left" title="Create Pos" style="height:30px;font-size:13px;width:100px;color:#000000;">Create</a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div class="pull">
                            <table width="100%" id='filter' >
                                <tr>
                                    <td width="2%">Work Center</td>
                                    <td width="3%">
                                        <select class="ddl" onChange="document.location.href = this.options[this.selectedIndex].value;">
                                            <?php foreach ($all_work_centers as $row) { ?>
                                                <option value="<?php echo site_url('pes/part_label_c/index/' .  trim($row->CHR_WORK_CENTER)); ?>"  <?php
                                                if ($work_center == trim($row->CHR_WORK_CENTER)) {
                                                    echo 'selected';
                                                }
                                                ?> > <?php echo trim($row->CHR_WORK_CENTER); ?> </option>
                                                    <?php } ?>
                                        </select>
                                    </td>
                                    <td width="95%" style='text-align:right;'>
                                        <!-- <input type="button" class="btn btn-primary" onclick="tableToExcel('exportToExcel', 'Production Per Hour')" value="Export to Excel" style="margin-bottom: 0px;"> -->
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div id="table-luar">
                            <table id="example" class="table table-condensed table-striped table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th style='text-align:center;'>No</th>
                                        <th style='text-align:center;'>Part No</th>
                                        <th style='text-align:center;'>Back No</th>
                                        <th style='text-align:center;'>Qty</th>
                                        <th style='text-align:center;'>Weight <br> Doses</th>
                                        <th style='text-align:center;'>Weight <br>/ Product</th>
                                        <th style='text-align:center;'>Weight <br> Total</th>
                                        <th style='text-align:center;'>Cust <br> P/N</th>
                                        <th style='text-align:center;'>Cust <br> B/N</th>
                                        <th style='text-align:center;'>Item <br>Name</th>
                                        <th style='text-align:center;'>Sloc</th>
                                        <th style='text-align:center;'>Item <br>Head</th>
                                        <th style='text-align:center;'>Prod <br>Marking</th>
                                        <th style='text-align:center;'>Box <br>Type</th>
                                        <th style='text-align:center;'>Customer</th>
                                        <th style='text-align:center;'>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    foreach ($data as $row) {
                                        echo "<tr class='gradeX'>";
                                        echo "<td style='text-align:center;'>$i</td>";
                                        echo "<td style='text-align:center;'>$row->part_no</td>";
                                        echo "<td style='text-align:center;'>$row->back_no</td>";
                                        echo "<td style='text-align:center;'>$row->qty</td>";
                                        echo "<td style='text-align:center;'>$row->weight_dus</td>";
                                        echo "<td style='text-align:center;'>$row->weight_per_product</td>";
                                        echo "<td style='text-align:center;'>$row->weight_total</td>";
                                        echo "<td style='text-align:center;'>$row->cust_part_no</td>";
                                        echo "<td style='text-align:center;'>$row->cust_back_no</td>";
                                        echo "<td style='text-align:left;'>$row->item_name</td>";
                                        echo "<td style='text-align:center;'>$row->sloc</td>";
                                        echo "<td style='text-align:center;'>$row->item_head</td>";
                                        echo "<td style='text-align:center;'>$row->prod_marking</td>";
                                        echo "<td style='text-align:center;'>$row->box_type</td>";
                                        echo "<td style='text-align:center;'>$row->customer</td>";
                                        ?>
                                    <td  style='text-align:center;'>
                                        <a data-toggle="modal" data-target="#modal_<?php echo $row->part_no; ?>" class="label label-warning"  data-placement="left" title="Give notes"><span class="fa fa-pencil"></span></a>
                                    </td>
                                    </tr>
                                    <?php
                                    $i++;
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- =========================================================================================================================== -->
    <?php
    foreach ($data as $isi) {
        ?>
        <div class="modal fade" id="modal_<?php echo $isi->part_no; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3" aria-hidden="true">
            <div class="modal-wrapper">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form class="form-horizontal" method="post"  role="form" action="<?php echo base_url('index.php/pes/part_label_c/update_part_label'); ?>" >
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title" id="myModalLabel3"><strong>EDIT DETAIL PART NO <?php echo trim($isi->part_no) ?></strong></h4>
                            </div>
                            <div class="modal-body" >
                                <input name="work_center" type='hidden' value='<?php echo $work_center ?>'/>
                                <input name="part_no" type='hidden' value='<?php echo $isi->part_no ?>' />

                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Back No</label>
                                        <div class="col-sm-3">
                                            <input name="back_no" type="text" class="form-control" value="<?php echo trim($isi->back_no); ?>"></input>
                                        </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Qty</label>
                                        <div class="col-sm-2">
                                            <input name="qty" type="number" class="form-control" value="<?php echo trim($isi->qty); ?>"></input>
                                        </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Weight Doses</label>
                                        <div class="col-sm-2">
                                            <input name="weight_dus" class="form-control" type="number" value="<?php echo trim($isi->weight_dus); ?>"></input>
                                        </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Weight Per Product</label>
                                        <div class="col-sm-2">
                                            <input name="weight_per_product" class="form-control" type="number" value="<?php echo trim($isi->weight_per_product); ?>"></input>
                                        </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Weight Total</label>
                                        <div class="col-sm-2">
                                            <input name="weight_total" class="form-control" type="number" value="<?php echo trim($isi->weight_total); ?>"></input>
                                        </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Cust Part No</label>
                                        <div class="col-sm-4">
                                            <input name="cust_part_no" class="form-control" type="text" value="<?php echo trim($isi->cust_part_no); ?>"></input>
                                        </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Cust Back No</label>
                                        <div class="col-sm-3">
                                            <input name="cust_back_no" class="form-control" type="text" value="<?php echo trim($isi->cust_back_no); ?>"></input>
                                        </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Sloc</label>
                                        <div class="col-sm-3">
                                            <input name="sloc" class="form-control" type="text" value="<?php echo trim($isi->sloc); ?>"></input>
                                        </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Item Head</label>
                                        <div class="col-sm-2">
                                            <input name="item_head" class="form-control" type="text" value="<?php echo trim($isi->item_head); ?>"></input>
                                        </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Prod Marking</label>
                                        <div class="col-sm-4">
                                            <input name="prod_marking" class="form-control" type="text" value="<?php echo trim($isi->prod_marking); ?>"></input>
                                        </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Box Type</label>
                                        <div class="col-sm-2">
                                            <input name="box_type" class="form-control" type="text" value="<?php echo trim($isi->box_type); ?>"></input>
                                        </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Customer</label>
                                        <div class="col-sm-6">
                                            <input name="customer" class="form-control" type="text" value="<?php echo trim($isi->customer); ?>"></input>
                                        </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Item Name</label>
                                        <div class="col-sm-5">
                                            <textarea name="item_name" rows="4" cols="40"><?php echo trim($isi->item_name); ?></textarea>
                                        </div>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default" data-dismiss="modal"> Close</button>
                                    <button type="submit" class="btn btn-success"> Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
    ?>
    <!-- =========================================================================================================================== -->

</aside>


<script src="<?php echo base_url('assets/js/jquery-1.12.3.js') ?>"></script>
<script src="<?php echo base_url('assets/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?php echo base_url('assets/js/dataTables.fixedColumns.min.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/css/fixedColumns.dataTables.min.css'); ?>" >
<script>
      $(document).ready(function () {
          var table = $('#example').DataTable({
              scrollY: "350px",
              scrollX: true,
              scrollCollapse: true,
              paging: false,
              fixedColumns: {
                  leftColumns: 2
              }
          });
          $('.dataTables_filter input').attr('placeholder', 'Search');
      });
</script>

