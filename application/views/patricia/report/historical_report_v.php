<script>
    $(document).ready(function () {
        $("#datepicker1").datepicker({dateFormat: 'dd-mm-yy'}).val();
        $("#datepicker2").datepicker({dateFormat: 'dd-mm-yy'}).val();
    };
</script>
<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/"') ?>"><span>Home</span></a></li>
            <li> <a href="#"><strong>HISTORICAL REPORT</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <?php if ($msg != NULL) {
            echo $msg;
        } ?>

        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-sitemap"></i>
                        <span class="grid-title"><strong>HISTORICAL REPORT</strong> TABLE</span>
                    </div>
                    <div class="grid-body">
                        <input name="CHR_DATE_SELECTED" value="<?php echo $selected_date_awal ?>" type="hidden">
                        <input name="CHR_DATE_SELECTED" value="<?php echo $selected_date_akhir ?>" type="hidden">
                        <?php 
                            $selecteddate2 = '';
                            $selecteddate1 = '';
                            if($selected_date_awal!='')
                            {
                                $selecteddate1 = date("m/d/Y", strtotime($selected_date_awal));
                            }
                            if($selected_date_akhir!='')
                            {
                                $selecteddate2 = date("m/d/Y", strtotime($selected_date_akhir));
                            }
                            
                        ?>
                        <div class="pull">
                            
                                <table width="80%" id='filter' border=0px>
                                    <form method="POST" action="<?php echo site_url('patricia/historical_report_c/search/'); ?>">
                                    <tr>
                                        <td width="5%">Filter</td>
                                        <td width="10%">
                                            <input  name="tanggal_awal" id="datepicker1" class="form-control" placeholder="Start Date" autocomplete="off"  type="text" style="width: 125px;text-transform: uppercase;" value="<?php echo $selecteddate1 ?>">
                                        </td>
                                        <td width="5%">s/d</td>
                                        <td width="12%">
                                            <input  name="tanggal_akhir" id="datepicker2" class="form-control" placeholder="End Date" autocomplete="off"  type="text" style="width: 125px;text-transform: uppercase;" value="<?php echo $selecteddate2 ?>">
                                        </td>
                                        <td width="5%">Status</td>
                                        <td width="10%">
                                            <select id="statusChecksheet" name="statusChecksheet" style="width:150px" class="ddl"  >
                                                <option value="" <?php if($selected_status==''){ echo "Selected"; } ?>>ALL</option>
                                                <option value="Checked" <?php if($selected_status=='Checked'){ echo "Selected"; } ?>>Checked</option>
                                                <option value="Unchecked" <?php if($selected_status=='Unchecked'){ echo "Selected"; } ?>>Unchecked</option>
                                                <option value="Same" <?php if($selected_status=='Same'){ echo "Selected"; } ?>>Same Load</option>
                                            </select>
                                        </td>
                                        <td width="15%" style="padding-top: 3px">
                                            <button type="submit" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Filter this data"><i class="fa fa-search"></i> Search</button>
                                        </td>
                                    </tr>
                                    </form>
                                </table>
                            
                            <table></table>
                        </div>
                        <br/>
                        <table id="dataTables1" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th >No</th>
                                    <th>Date</th>
                                    <th>Part Number</th>
                                    <th width="20%">Part Name</th>
									<th width="20%">Supplier</th>
                                    <th width="15%">Status Checksheet</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $i = 1;
                                    foreach ($data as $isi) {
                                        echo "<tr class='gradeX'>";
                                        echo "<td >$i</td>";
                                        echo "<td>".date("d F Y", strtotime($isi->CHR_CREATED_DATE))."</td>";
                                        echo "<td>$isi->CHR_ID_PART</td>"; 
                                        echo "<td>$isi->CHR_NAMA_PART</td>";
                                        echo "<td>$isi->CHR_NAMA_VENDOR</td>";
                                        echo "<td>$isi->CHR_STATUS</td>";
                                        
                                    ?>
                                    <td>
                                        <?php if($isi->CHR_STATUS!="Unchecked"){ ?>
                                            <a href="<?php echo base_url('index.php/patricia/report_checksheet_c/excel_checksheet/'.$isi->CHR_MODIFIED_DATE."/".$isi->CHR_ID_PART.'') ?>" data-placement="left" data-toggle="tooltip" title="Checksheet" class="label label-default"><span class="fa fa-download"></span></a>
                                        <?php } ?>
                                        
                                        <?php if($isi->INT_TR_ID!=null){ ?>
                                            <a href="<?php echo base_url('index.php/patricia/technical_report_c/excel_technical/'.$isi->INT_TR_ID.'') ?>" id="detail" class="label label-info" data-placement="top" data-toggle="tooltip" title="Technical Report"><span class="fa fa-download"></span></a>
                                        <?php } ?>
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
        
    </section>
</aside>


