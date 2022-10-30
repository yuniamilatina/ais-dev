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
            <li><!-- <a href="<?php echo base_url('index.php/qc/qc/'); ?>"> --><strong>Report QC</strong></li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-wrench"></i>
                        <span class="grid-title">Report QC</span>
                        <form action="" method="POST"> 
                        <div style="float: right;">
                            <table>
                                <tr>
                                    <th class="tg-031e">
                                        <label class="control-label" style="float: right;margin-top: 5px; margin-right: 15px">From :</label> 
                                    </th>
                                    <th class="tg-031e">
                                        <div class="controls input-append">
                                            <div class="controls input-append date">
                                                <span class="add-on"><i class="icon-th"></i></span>
                                                    <!-- <input size="16" type="text" name="start_date" id="datepicker1" readonly style="width: 100px;border-radius: 0 4px 4px 0;-moz-border-radius: 0 4px 4px 0;webkit-border-radius: 0 4px 4px 0;margin-right: 10px"> -->
                                                    <?php if (empty($start_date)) { ?>
                                                        <input size="16" type="text" name="start_date" id="datepicker1" value="<?php echo date(date_format_setting()); ?>" readonly style="width: 120px;border-radius: 0 4px 4px 0;-moz-border-radius: 0 4px 4px 0;webkit-border-radius: 0 4px 4px 0;">
                                                    <?php } else { ?>
                                                        <input size="16" type="text" name="start_date" id="datepicker1" value="<?php echo date("m/d/Y", strtotime($start_date)); ?>" readonly style="width: 120px;border-radius: 0 4px 4px 0;-moz-border-radius: 0 4px 4px 0;webkit-border-radius: 0 4px 4px 0;">
                                                    <?php } ?>
                                            </div>
                                        </div>
                                    </th>
                                    <th class="tg-031e">
                                        <label class="control-label" style="float: right;margin-top: 5px; margin-right: 15px">To :</label> 
                                    </th>
                                    <th class="tg-031e">
                                        <div class="controls input-append">
                                            <div class="controls input-append date">
                                                <span class="add-on"><i class="icon-th"></i></span>
                                                    <!-- <input size="16" type="text" name="finish_date" id="datepicker" readonly style="width: 100px;border-radius: 0 4px 4px 0;-moz-border-radius: 0 4px 4px 0;webkit-border-radius: 0 4px 4px 0;margin-right: 10px"> -->
                                                    <?php if (empty($finish_date)) { ?>
                                                        <input size="16" type="text" name="finish_date" id="datepicker" value="<?php echo date(date_format_setting()); ?>" readonly style="width: 120px;border-radius: 0 4px 4px 0;-moz-border-radius: 0 4px 4px 0;webkit-border-radius: 0 4px 4px 0;">
                                                    <?php } else { ?>
                                                        <input size="16" type="text" name="finish_date" id="datepicker" value="<?php echo date("m/d/Y", strtotime($finish_date)); ?>" readonly style="width: 120px;border-radius: 0 4px 4px 0;-moz-border-radius: 0 4px 4px 0;webkit-border-radius: 0 4px 4px 0;">
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
                            <th style="text-align: center;">No.</th>
                            <th style="text-align: center;">QCE Number</th>
                            <th style="text-align: center;">Delivery Number</th>
                            <th style="text-align: center;">Create Date</th>
                            <th style="text-align: center;">Cancel Status</th>
                            <th style="text-align: center;">Action</th>
                          </thead>
                          <tbody>
                            <?php
                            $no = 1;

                                foreach ($report as $data) {
                                ?>
                                <tr>
                                    <td align="center" style="text-align: center; font-size: 12px"><?php echo $no; ?></td>
                                    <td align="center" style="text-align: center; font-size: 12px"><?php echo anchor('qc/qc/report_detail/'. $data->INT_QCE_NO, $data->INT_QCE_NO)?></td>
                                    <td align="center" style="text-align: center; font-size: 12px"><?php echo $data->CHR_DEL_NO; ?></td>
                                    <td align="center" style="text-align: center; font-size: 12px"><?php echo date("d-m-Y", strtotime($data->CHR_CREATE_DATE)); ?></td>
                                    <?php
                                            $stat = $data->CHR_CANCEL_STATUS;
                                            if($stat == 1){
                                                echo '<td style="text-align: center; background-color: red; color: white; font-size: 12px" class="tg-b7b8">Canceled</td>';
                                            }else if(($stat != 1) || (is_null($stat)) || ($stat == '')){
                                                echo '<td style="text-align: center; font-size: 12px" class="tg-b7b8">-</td>';
                                            }
                                    ?>
                                    <td align="center" style="text-align: center; font-size: 12px">
                                        <div class="options btn-group">
                                        <?php
                                            $stat = $data->CHR_CANCEL_STATUS;
                                            if($stat == 1){
                                                ?>
                                                    <a class="btn btn-primary" style="border-radius: 5px" disabled>Reprint QC Sheet</a>
                                                <?php
                                            }else if(($stat != 1) || (is_null($stat)) || ($stat == '')){
                                                ?>  
                                                    <a class="btn btn-primary" style="border-radius: 3px" href="<?php echo site_url('qc/qc/generate/' . $data->INT_QCE_NO); ?>" target="_blank">Reprint QC Sheet</a>
                                                <?php
                                            }
                                        ?>
                                        </div>
                                    </td>
                                </tr>
                                <?php
                                $no++;
                            }
                            ?>
                          </tbody>
                        </table>
                    </div>
                </div>
            </div>
    </section>
    </div> 
</aside>