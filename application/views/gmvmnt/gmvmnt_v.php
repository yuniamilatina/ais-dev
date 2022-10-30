<style type="text/css">
.tg  {border-collapse:collapse;border-spacing:0;border-color:#ccc;}
.tg td{font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:0px;overflow:hidden;word-break:normal;border-color:#ccc;color:#333;background-color:#fff;border-top-width:1px;border-bottom-width:1px;}
.tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:0px;overflow:hidden;word-break:normal;border-color:#ccc;color:#333;background-color:#f0f0f0;border-top-width:1px;border-bottom-width:1px;}
.tg .tg-yw4l{vertical-align:top}
.tg .tg-4eph{background-color:#f9f9f9}
.tg .tg-b7b8{background-color:#f9f9f9;vertical-align:top}
</style>

<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/'); ?>"><span>Home</span></a></li>
            <li><!-- <a href="<?php echo base_url('index.php/qc/qc/'); ?>"> --><strong>Error Log Good Movement (Return Error from SAP)</strong></li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-wrench"></i>
                        <span class="grid-title">Error Log Good Movement</span>
                        <form action="" method="POST"> 
                        <div style="float: right;">
                            <table>
                                <tr>
                                    <th class="tg-031e">
                                        <label class="fa" style="float: right;margin-top: 5px; margin-right: 15px; font-size: 18px">From :</label> 
                                    </th>
                                    <th class="tg-031e">
                                        <div class="controls input-append">
                                            <div class="controls input-append date">
                                                <span class="add-on"><i class="icon-th"></i></span>
                                                    <!-- <input size="16" type="text" name="start_date" id="datepicker1" readonly style="width: 100px;border-radius: 0 4px 4px 0;-moz-border-radius: 0 4px 4px 0;webkit-border-radius: 0 4px 4px 0;margin-right: 10px"> -->
                                                    <?php if (empty($start_date)) { ?>
                                                        <input size="16" type="text" name="start_date" id="datepicker1" value="<?php echo date(date_format_setting()); ?>" readonly style="padding-left: 5px; color:#3498db; width: 120px;border-radius: 0 4px 4px 0;-moz-border-radius: 0 4px 4px 0;webkit-border-radius: 0 4px 4px 0;">
                                                    <?php } else { ?>
                                                        <input size="16" type="text" name="start_date" id="datepicker1" value="<?php echo date("m/d/Y", strtotime($start_date)); ?>" readonly style="padding-left: 5px; color:#3498db;width: 120px;border-radius: 0 4px 4px 0;-moz-border-radius: 0 4px 4px 0;webkit-border-radius: 0 4px 4px 0;">
                                                    <?php } ?>
                                            </div>
                                        </div>
                                    </th>
                                    <th class="tg-031e">
                                        <label class="fa" style="float: right;margin-top: 5px; margin-right: 15px; font-size: 18px">To :</label> 
                                    </th>
                                    <th class="tg-031e">
                                        <div class="controls input-append">
                                            <div class="controls input-append date">
                                                <span class="add-on"><i class="icon-th"></i></span>
                                                    <!-- <input size="16" type="text" name="finish_date" id="datepicker" readonly style="width: 100px;border-radius: 0 4px 4px 0;-moz-border-radius: 0 4px 4px 0;webkit-border-radius: 0 4px 4px 0;margin-right: 10px"> -->
                                                    <?php if (empty($finish_date)) { ?>
                                                        <input size="16" type="text" name="finish_date" id="datepicker" value="<?php echo date(date_format_setting()); ?>" readonly style="padding-left: 5px; color:#3498db;width: 120px;border-radius: 0 4px 4px 0;-moz-border-radius: 0 4px 4px 0;webkit-border-radius: 0 4px 4px 0;">
                                                    <?php } else { ?>
                                                        <input size="16" type="text" name="finish_date" id="datepicker" value="<?php echo date("m/d/Y", strtotime($finish_date)); ?>" readonly style="padding-left: 5px; color:#3498db;width: 120px;border-radius: 0 4px 4px 0;-moz-border-radius: 0 4px 4px 0;webkit-border-radius: 0 4px 4px 0;">
                                                    <?php } ?>
                                            </div>
                                        </div>
                                    </th>
                                    <th class="tg-031e">
                                        <button style="margin-right: 10px; border-radius: 3px" class="btn btn-primary" id="btn_filter_date" name="btn_filter_by_date" value="1"><i class="icon-ok icon-white"></i>Filter</button>
                                    </th>
                                </tr>
                            </table>
                        </div>
                        </form>
                    </div>
                    <div class="grid-body">
                      <table id="dataTables1" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
                          <thead>
                            <!-- <th style="text-align: center; vertical-align: middle;">Error Status</th> -->
                            <th style="text-align: center; vertical-align: middle;">Upload Date</th>
                            <th style="text-align: center; vertical-align: middle;">Error Log Message</th>
                            <th style="text-align: center; vertical-align: middle;">Part Number</th>
                            <th style="text-align: center; vertical-align: middle;">Part Name</th>
                            <th style="text-align: center; vertical-align: middle;">Trans Type</th>
                            <th style="text-align: center; vertical-align: middle;">Movement Type</th>
                            <th style="text-align: center; vertical-align: middle;">Sloc From</th>
                            <th style="text-align: center; vertical-align: middle;">Sloc To</th>
                            <th style="text-align: center; vertical-align: middle;">Number</th>
                            <th style="text-align: center; vertical-align: middle;">Number Item</th>
                          </thead>
                          <tbody>
                            <?php 
                                    foreach($error as $row){ ?>
                                            <tr>
                                                <!-- <?php 
                                                    if($row->CHR_STATUS = 'E'){
                                                      echo '<td align="center" style="color:white; background-color:red">Error</td>';
                                                    }
                                                ?> -->
                                               <td align="center"><?php echo date("d-m-Y", strtotime($row->CHR_DATE_UPLOAD)) ;?></td>
                                               <td align="center"><?php echo $row->CHR_MESSAGE ;?></td>
                                               <td align="center"><?php echo $row->CHR_PART_NO ;?></td>
                                               <td align="center"><?php echo $row->CHR_PART_NAME ;?></td>
                                               <td align="center"><?php echo $row->CHR_TYPE_TRANS ;?></td>
                                               <td align="center"><?php echo $row->CHR_MVMT_TYPE ;?></td>
                                               <td align="center"><?php echo $row->CHR_SLOC_FROM ;?></td>
                                               <td align="center"><?php echo $row->CHR_SLOC_TO ;?></td>
                                               <td align="center"><?php echo $row->INT_NUMBER ;?></td>
                                               <td align="center"><?php echo $row->INT_NUMBER_ITEM ;?></td>
                                                
                                            </tr>
                                         <?php } ?>
                          </tbody>
                        </table>
                    </div>
                </div>
            </div>
    </section>
    </div> 
</aside>