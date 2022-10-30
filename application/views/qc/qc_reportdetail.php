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
            <li><!--<a href="<?php echo base_url('index.php/qc/qc/report'); ?>"> --><strong>Report QC</strong></li>
            <li><!-- <a href="<?php echo base_url('index.php/qc/qc/'); ?>"> --><strong>Report QC Detail</strong></li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-wrench"></i>
                        <span class="grid-title">Report QC Detail For - <?php echo $qce_no; ?></span>
                        <?php
                                //echo $canceled; 
                                if($canceled == 1){
                                    // $canceled = "Canceled";
                                    echo '<span class="grid-title" style="float: right; margin-right: 10px; background-color: red; color:white; ">Canceled</span>';
                                }else{
                                	//do nothing
                                }

                        ?>
                    </div>
                    <div class="grid-body">
                        <table id="dataTables1" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
                          <thead>
                            <th style="text-align: center;" class="tg-031e">No.</th>
                            <th style="text-align: center;" class="tg-031e">QCE Number</th>
                            <th style="text-align: center;" class="tg-031e">QCE Line Item</th>
                            <th style="text-align: center;" class="tg-031e">Part Number</th>
                            <th style="text-align: center;" class="tg-031e">Part Name</th>
                            <th style="text-align: center;" class="tg-031e">Return Qty</th>
                            <th style="text-align: center;" class="tg-031e">Good Qty</th>
                            <th style="text-align: center;" class="tg-031e">Repair Qty</th>
                            <th style="text-align: center;" class="tg-yw4l">Claim Qty</th>
                            <th style="text-align: center;" class="tg-yw4l">Scrap Qty</th>
                            <th style="text-align: center;" class="tg-yw4l">Sloc To</th>
                          </thead>
                          <tbody>
                            <?php
                            $no = 1;
                            foreach ($report as $data) {
                            ?>
                            <tr>
                                <td align="center" style="text-align: center; font-size: 12px" class="tg-4eph"><?php echo $no; ?></td>
                                <td align="center" style="text-align: center; font-size: 12px" class="tg-4eph"><?php echo $data->INT_QCE_NO; ?></td>
                                <td align="center" style="text-align: center; font-size: 12px" class="tg-4eph"><?php echo $data->INT_QCE_ITEM; ?></td>
                                <td align="center" style="text-align: center; font-size: 12px" class="tg-4eph">
                                    <?php
                                        //echo $data->CHR_PART_NO; 
                                        $partno = trim($data->CHR_PART_NO);
                                        //$partno = trim('-1234567890abcdef');
                                        $length = strlen($partno);
                                        $bag1   = substr($partno, 0, 6);
                                        $sisa   = (int)$length - 6;
                                        //echo $sisa;
                                        if($sisa <= 5){
                                            $bag2 = substr($partno, 6, $sisa);
                                        }else{
                                            $bag2 = substr($partno, 6, 5);
                                            $sisa = (int)$length - 11;
                                        }
                                        //echo $sisa;
                                        $partsisa = substr($partno, 11, $sisa);
                                        $bag3     = str_split($partsisa, 2);
                                        //echo $partsisa;
                                        if(substr($bag1, 0, 1) == '-'){
                                            $bag1 = str_replace('-', '', $bag1);
                                        }

                                        $partnobaru = $bag1.'-'.$bag2;
                                        //echo $partnobaru;
                                        for($i = 0; $i < sizeof($bag3); $i++){
                                            if($bag3[$i] == ''){
                                                $partnobaru .= $bag3[$i];
                                            }else{
                                                $partnobaru .= '-'.$bag3[$i];
                                            }
                                        }

                                        echo $partnobaru; 
                                    ?>
                                </td>
                                <td align="center" style="text-align: center; font-size: 12px" class="tg-4eph">
                                    <?php
                                        $part_name = $this->db->query("SELECT CHR_PART_NAME FROM TM_PARTS WHERE CHR_PART_NO = '".$data->CHR_PART_NO."'")->result();

                                        echo @$part_name[0]->CHR_PART_NAME;
                                    ?>
                                </td>
                                <td align="center" style="text-align: center; font-size: 12px" class="tg-4eph"><?php echo $data->INT_DEL_QTY; ?></td>
                                <td align="center" style="text-align: center; font-size: 12px" class="tg-4eph"><?php echo $data->INT_GOODS_QTY; ?></td>
                                <td align="center" style="text-align: center; font-size: 12px" class="tg-4eph"><?php echo $data->INT_REPAIR_QTY; ?></td>
                                <td align="center" style="text-align: center; font-size: 12px" class="tg-b7b8"><?php echo $data->INT_CLAIM_QTY; ?></td>
                                <td align="center" style="text-align: center; font-size: 12px" class="tg-b7b8"><?php echo $data->INT_SCRAP_QTY; ?></td>
                                <td align="center" style="text-align: center; font-size: 12px" class="tg-b7b8"><?php echo $data->CHR_SLOC_TO; ?></td>
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