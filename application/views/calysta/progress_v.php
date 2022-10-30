<style type="text/css">
.green {
    background-color: green;
}
</style>
<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/"') ?>"><span>Home</span></a></li>
            <li> <a href="#"><strong>PROGRESS PART</strong></a></li>
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
                        <span class="grid-title"><strong>PROGRESS PART</strong> TABLE</span>
                    </div>

                    <div class="grid-body">
                         <?php
                    echo form_open_multipart('calysta/progress_c/dashboard', 'class="form-horizontal"');
                    ?>
                      <div class="form-group">
                            <label class="col-sm-1 control-label">Kategori</label>
                                <div class="col-sm-3">
                                    <select  name="CHR_PROJECT" id="e1"  onchange="get_data(); document.getElementById('project_id').value=this.options[this.selectedIndex].value;"  class="form-control"  placeholder="Pilih Kategori"value="<?= $tmn; ?>">
                                    <option value=""></option>
                                        <option value="01">Project Desain</option>
                                        <option value="02">Deis MTE</option>
                                        <option value="03">Engineering</option>
                                        <option value="04">Quality</option>
                                        <option value="05">Produksi</option>
                                    </select>
                                </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-1 control-label">Project</label>
                                <div class="col-sm-3">
                                    <select  name="CHR_PROJECT_NAME" id="e2"   onchange="document.getElementById('project_name_id').value=this.options[this.selectedIndex].value;"  class="form-control"  placeholder="Pilih Project" value="<?= $tmn; ?>">
                                        <option value=""></option>
                                   <?php  foreach($dropdown as $row) { 
                                    echo '<option value="'.$row->CHR_PROJECT_NAME.'">'.$row->CHR_PROJECT_NAME.'</option>';
                                        }
                                        ?>
                                        
<!--
                                         <?php
                                            foreach ($dropdown as $row) {
                                                if (trim($project) == 0) {
                                                    ?>
                                                    <option selected value="<?php echo trim($project); ?>" > <?php echo trim($project); ?> </option>
                                                <?php } else { ?>
                                                    <option value="<?php echo trim($row->CHR_PROJECT_NAME); ?>" > <?php echo trim($row->CHR_PROJECT_NAME); ?> </option>
                                                    <?php
                                                }
                                            }
                                            ?>
-->
                                    </select>
                                </div>
                        </div> 
                        
                        <div class="form-group">
                            <div class="col-sm-offset-1 col-sm-3">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-primary">TAMPILKAN</button>
                                       
                                </div>
                            </div>
                        </div>
                         <?php echo form_close(); ?>
                      
                        <table id="dataTables1" class="table table-striped table-condensed table-hover display" cellspacing="0" width="133%">
                            <thead>
                                <tr>
                                    <th rowspan="2" style="width:2%">No.</th>
                                    <th rowspan="2" style="text-align:center; width:8%">TM Number</th>
                                    <th rowspan="2" style="text-align:center; width:8%">Project Name</th>
                                    <th rowspan="2" style="text-align:center; width:13%">Part Name</th>
                                    <th rowspan="2" style="text-align:center; width:8%">QTY</th>
                                    <th colspan="2" style="text-align:center; width:8%;">RM</th>
                                    <th colspan="2" style="text-align:center; width:8%;">MC1</th>
                                    <th colspan="2" style="text-align:center; width:8%;">HT</th>
                                    <th colspan="2" style="text-align:center; width:8%;">SG</th>
                                    <th colspan="2" style="text-align:center; width:8%;">WC</th>
                                    <th colspan="2" style="text-align:center; width:8%;">MC2</th>
                                    <th colspan="2" style="text-align:center; width:8%;">QC</th>
                                    <th colspan="2" style="text-align:center; width:8%;">FINISHING</th>
                                     <th rowspan="2" style="text-align:center; width:8%">ACTIONS</th>
                                </tr>
                                <tr>
                                    <th style="text-align:center; width:8%; background-color: red; color:white;">P</th>
                                        <th style="text-align:center; width:8%; background-color: green; color:white;">A</th>
                                    <th style="text-align:center; width:8%; background-color: red; color:white;">P</th>
                                        <th style="text-align:center; width:8%; background-color: green; color:white;">A</th>
                                    <th style="text-align:center; width:8%; background-color: red; color:white;">P</th>
                                        <th style="text-align:center; width:8%; background-color: green; color:white;">A</th>
                                    <th style="text-align:center; width:8%; background-color: red; color:white;">P</th>
                                        <th style="text-align:center; width:8%; background-color: green; color:white;">A</th>
                                    <th style="text-align:center; width:8%; background-color: red; color:white;">P</th>
                                        <th style="text-align:center; width:8%; background-color: green; color:white;">A</th>
                                    <th style="text-align:center; width:8%; background-color: red; color:white;">P</th>
                                        <th style="text-align:center; width:8%; background-color: green; color:white;">A</th>
                                    <th style="text-align:center; width:8%; background-color: red; color:white;">P</th>
                                        <th style="text-align:center; width:8%; background-color: green; color:white;">A</th>
                                    <th style="text-align:center; width:8%; background-color: red; color:white;">P</th>
                                        <th style="text-align:center; width:8%; background-color: green; color:white;">A</th>
                                    </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $i = 1;
                                    foreach ($data as $isi) {
                                        echo "<tr class='gradeX'>";
                                        echo "<td>$i</td>";
                                        echo "<td>$isi->CHR_TM_NUMBER</td>";
                                        echo "<td>$isi->CHR_PROJECT_NAME</td>";
                                        echo "<td>$isi->CHR_PART_NAME</td>";
                                        echo "<td><center>$isi->INT_QTY</center></td>";                                        
                                        if($isi->CHR_PROG_RM == NULL || $isi->CHR_PROG_RM == "" || $isi->CHR_PROG_RM == " "){
                                            echo "<td style='text-align:center;'><strong>-</strong></td>";
                                        } else {
                                            echo "<td style='text-align:center; '><strong>" . substr($isi->CHR_PROG_RM,6,2) . "/" . substr($isi->CHR_PROG_RM,4,2) . "/" . substr($isi->CHR_PROG_RM,0,4) . "</strong></td>";
                                        }
                                            if($isi->CHR_STATUS_RM == NULL || $isi->CHR_STATUS_RM == "" || $isi->CHR_STATUS_RM == " "){
                                                echo "<td style='text-align:center;'><strong>-</strong></td>";
                                            } else {
                                                echo "<td style='text-align:center;'><strong>" . substr($isi->CHR_STATUS_RM,8,2) . "/" . substr($isi->CHR_STATUS_RM,5,2) . "/" . substr($isi->CHR_STATUS_RM,0,4) . "</strong></td>";
                                            }                                            
                                        if($isi->CHR_PROG_MC1 == NULL || $isi->CHR_PROG_MC1 == "" || $isi->CHR_PROG_MC1 == " "){
                                            echo "<td style='text-align:center;'><strong>-</strong></td>";
                                        } else {
                                            echo "<td style='text-align:center;'><strong>" . substr($isi->CHR_PROG_MC1,6,2) . "/" . substr($isi->CHR_PROG_MC1,4,2) . "/" . substr($isi->CHR_PROG_MC1,0,4) . "</strong></td>";
                                        }
                                            if($isi->CHR_STATUS_MC1 == NULL || $isi->CHR_STATUS_MC1 == "" || $isi->CHR_STATUS_MC1 == " "){
                                                echo "<td style='text-align:center;'><strong>-</strong></td>";
                                            } else {
                                                echo "<td style='text-align:center;'><strong>" . substr($isi->CHR_STATUS_MC1,8,2) . "/" . substr($isi->CHR_STATUS_MC1,5,2) . "/" . substr($isi->CHR_STATUS_MC1,0,4) . "</strong></td>";
                                            }
                                        if($isi->CHR_PROG_HT == NULL || $isi->CHR_PROG_HT == "" || $isi->CHR_PROG_HT == " "){
                                            echo "<td style='text-align:center;'><strong>-</strong></td>";
                                        } else {
                                            echo "<td style='text-align:center;'><strong>" . substr($isi->CHR_PROG_HT,6,2) . "/" . substr($isi->CHR_PROG_HT,4,2) . "/" . substr($isi->CHR_PROG_HT,0,4) . "</strong></td>";
                                        }
                                            if($isi->CHR_STATUS_HT == NULL || $isi->CHR_STATUS_HT == "" || $isi->CHR_STATUS_HT == " "){
                                                echo "<td style='text-align:center;'><strong>-</strong></td>";
                                            } else {
                                                echo "<td style='text-align:center;'><strong>" . substr($isi->CHR_STATUS_HT,8,2) . "/" . substr($isi->CHR_STATUS_HT,5,2) . "/" . substr($isi->CHR_STATUS_HT,0,4) . "</strong></td>";
                                            }
                                        if($isi->CHR_PROG_SG == NULL || $isi->CHR_PROG_SG == "" || $isi->CHR_PROG_SG == " "){
                                            echo "<td style='text-align:center;'><strong>-</strong></td>";
                                        } else {
                                            echo "<td style='text-align:center;'><strong>" . substr($isi->CHR_PROG_SG,6,2) . "/" . substr($isi->CHR_PROG_SG,4,2) . "/" . substr($isi->CHR_PROG_SG,0,4) . "</strong></td>";
                                        }
                                            if($isi->CHR_STATUS_SG == NULL || $isi->CHR_STATUS_SG == "" || $isi->CHR_STATUS_SG == " "){
                                                echo "<td style='text-align:center;'><strong>-</strong></td>";
                                            } else {
                                                echo "<td style='text-align:center;'><strong>" . substr($isi->CHR_STATUS_SG,8,2) . "/" . substr($isi->CHR_STATUS_SG,5,2) . "/" . substr($isi->CHR_STATUS_SG,0,4) . "</strong></td>";
                                            }
                                        if($isi->CHR_PROG_WC == NULL || $isi->CHR_PROG_WC == "" || $isi->CHR_PROG_WC == " "){
                                            echo "<td style='text-align:center;'><strong>-</strong></td>";
                                        } else {
                                            echo "<td style='text-align:center;'><strong>" . substr($isi->CHR_PROG_WC,6,2) . "/" . substr($isi->CHR_PROG_WC,4,2) . "/" . substr($isi->CHR_PROG_WC,0,4) .  "</strong></td>";
                                        }
                                            if($isi->CHR_STATUS_WC == NULL || $isi->CHR_STATUS_WC == "" || $isi->CHR_STATUS_WC == " "){
                                                echo "<td style='text-align:center;'><strong>-</strong></td>";
                                            } else {
                                                echo "<td style='text-align:center;'><strong>" . substr($isi->CHR_STATUS_WC,8,2) . "/" . substr($isi->CHR_STATUS_WC,5,2) . "/" . substr($isi->CHR_STATUS_WC,0,4) . "</strong></td>";
                                            }
                                        if($isi->CHR_PROG_MC2 == NULL || $isi->CHR_PROG_MC2 == "" || $isi->CHR_PROG_MC2 == " "){
                                            echo "<td style='text-align:center;'><strong>-</strong></td>";
                                        } else {
                                            echo "<td style='text-align:center;'><strong>" . substr($isi->CHR_PROG_MC2,6,2) . "/" . substr($isi->CHR_PROG_MC2,4,2) . "/" . substr($isi->CHR_PROG_MC2,0,4) . "</strong></td>";
                                        }
                                            if($isi->CHR_STATUS_MC2 == NULL || $isi->CHR_STATUS_MC2 == "" || $isi->CHR_STATUS_MC2 == " "){
                                                echo "<td style='text-align:center;'><strong>-</strong></td>";
                                            } else {
                                                echo "<td style='text-align:center;'><strong>" . substr($isi->CHR_STATUS_MC2,8,2) . "/" . substr($isi->CHR_STATUS_MC2,5,2) . "/" . substr($isi->CHR_STATUS_MC2,0,4) . "</strong></td>";
                                            }
                                        if($isi->CHR_PROG_QC == NULL || $isi->CHR_PROG_QC == "" || $isi->CHR_PROG_QC == " "){
                                            echo "<td style='text-align:center;'><strong>-</strong></td>";
                                        } else {
                                            echo "<td style='text-align:center;'><strong>" . substr($isi->CHR_PROG_QC,6,2) . "/" . substr($isi->CHR_PROG_QC,4,2) . "/" . substr($isi->CHR_PROG_QC,0,4) . "</strong></td>";
                                        }
                                            if($isi->CHR_STATUS_QC == NULL || $isi->CHR_STATUS_QC == "" || $isi->CHR_STATUS_QC == " "){
                                                echo "<td style='text-align:center;'><strong>-</strong></td>";
                                            } else {
                                                echo "<td style='text-align:center;'><strong>" . substr($isi->CHR_STATUS_QC,8,2) . "/" . substr($isi->CHR_STATUS_QC,5,2) . "/" . substr($isi->CHR_STATUS_QC,0,4) . "</strong></td>";
                                            }
                                        if($isi->CHR_PROG_FIN == NULL || $isi->CHR_PROG_FIN == "" || $isi->CHR_PROG_FIN == " "){
                                            echo "<td style='text-align:center;'><strong>-</strong></td>";
                                        } else {
                                            echo "<td style='text-align:center;'><strong>" . substr($isi->CHR_PROG_FIN,6,2) . "/" . substr($isi->CHR_PROG_FIN,4,2) . "/" . substr($isi->CHR_PROG_FIN,0,4) . "</strong></td>";
                                        }
                                            if($isi->CHR_STATUS_FIN == NULL || $isi->CHR_STATUS_FIN == "" || $isi->CHR_STATUS_FIN == " "){
                                                echo "<td style='text-align:center;'><strong>-</strong></td>";
                                            } else {
                                                echo "<td style='text-align:center;'><strong>" . substr($isi->CHR_STATUS_FIN,8,2) . "/" . substr($isi->CHR_STATUS_FIN,4,2) . "/" . substr($isi->CHR_STATUS_FIN,0,4) . "</strong></td>";
                                            }
                                    ?>
<td style='text-align:center;'> 
    <a data-toggle="modal" data-target="#modaledit<?php echo $isi->CHR_TM_NUMBER; ?>" data-placement="center" data-toggle="tooltip" title="Edit Part" class="label label-info"><span class="fa fa-info"></span></a>
     <a data-toggle="modal" data-target="#modal<?php echo $isi->CHR_TM_NUMBER; ?>" data-placement="left" data-toggle="tooltip" title="Edit Part" class="label label-warning"><span class="fa fa-pencil"></span></a>
                                </td>
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

         <?php
            foreach ($duration as $d) {
                ?>
          <div class="modal fade" id="modaledit<?php echo $d->CHR_TM_NUMBER; ?>"  tabindex="-1" role="dialog" aria-labelledby="modaledit" aria-hidden="true" style="display: none;">
                    <div class="modal-wrapper">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                                    <h4 class="modal-title" id="modaledit"><strong>DURATION PROCESS - <?php echo $d->CHR_TM_NUMBER; ?></strong></h4>
                                </div>
                                <div class="modal-body">
                                    <?php echo form_open('calysta/progress_c/duration', 'class="form-horizontal"'); ?>
                                    <input name="CHR_TM_NUMBER" class="form-control"  type="hidden" style="width: 300px;" value="<?php echo $d->CHR_TM_NUMBER; ?>">
                                    <div class="form-group">
                                        <label class="col-sm-1 control-label"></label>
                                            <div class="col-sm-1 control-label" style="position: relative; left: 90px;">
                                               <label class="col-sm-3 control-label">Start</label>
                                            </div>
                                             <div class="col-sm-3 control-label" style="position: relative; left:185px;">
                                               <label class="col-sm-3 control-label">Finish</label>
                                            </div>
                                            <div class="col-sm-3 control-label" style="position: relative; left:180px;">
                                                <label class="col-sm-3 control-label">Duration</label>
                                            </div>
                                </div>
                                    <div class="form-group">
                                        <label class="col-sm-1 control-label" style="position: relative; left:30px;"><strong>MC1</strong></label>
                                            <div class="col-sm-3 control-label">
                                                <input style="width:125px; position: relative; left: 60px;" class="form-control" type="text" value="<?php echo $d->CHR_START_MC1 ?>" disabled>
                                            </div>
                                            <div class="col-sm-3 control-label">
                                                <input style="width:125px; position: relative; left: 60px;" class="form-control" type="text" value="<?php echo $d->CHR_STATUS_MC1 ?>" disabled>
                                            </div>
                                            <div class="col-sm-3 control-label">
                                                <input style="width:130px; position: relative; left: 60px;" class="form-control" id="total_mc1" type="text" value="<?php echo $d->CHR_JAM_MC1." Jam ".$d->CHR_MENIT_MC1." Menit" ?>"  disabled>
                                            </div>
                                    </div>
                                  
                                    <div class="form-group">
                                        <label class="col-sm-1 control-label" style="position: relative; left:30px;"><strong>SG</strong></label>
                                            <div class="col-sm-3 control-label">
                                                <input style="width:125px; position: relative; left: 60px;" class="form-control" type="text" value="<?php echo $d->CHR_START_SG ?>" disabled>
                                            </div>
                                             <div class="col-sm-3 control-label">
                                                <input style="width:125px; position: relative; left: 60px;" class="form-control" type="text" value="<?php echo $d->CHR_STATUS_SG ?>" disabled>
                                            </div>
                                            <div class="col-sm-3 control-label">
                                                <input style="width:130px; position: relative; left: 60px;" class="form-control" id="total_sg" type="text" value="<?php echo $d->CHR_JAM_SG." Jam ".$d->CHR_MENIT_SG." Menit" ?>" disabled>
                                            </div>
                                    </div>
                                   <div class="form-group">
                                        <label class="col-sm-1 control-label" style="position: relative; left:30px; "><strong>WC</strong></label>
                                            <div class="col-sm-3 control-label">
                                                <input style="width:125px; position: relative; left: 60px;" class="form-control" type="text" value="<?php echo $d->CHR_START_WC ?>" disabled>
                                            </div>
                                             <div class="col-sm-3 control-label">
                                                <input style="width:125px; position: relative; left: 60px;" class="form-control" type="text" value="<?php echo $d->CHR_STATUS_WC ?>" disabled>
                                            </div>
                                            <div class="col-sm-3 control-label">
                                                <input style="width:130px; position: relative; left: 60px;" class="form-control" id="total_wc" type="text" value="<?php echo $d->CHR_JAM_WC." Jam ".$d->CHR_MENIT_WC." Menit" ?>" disabled>
                                            </div>
                                    </div>
                                   <div class="form-group">
                                        <label class="col-sm-1 control-label" style="position: relative; left:30px;"><strong>MC2</strong></label>
                                            <div class="col-sm-3 control-label">
                                                <input style="width:125px; position: relative; left: 60px;" class="form-control" type="text" value="<?php echo $d->CHR_START_MC2 ?>" disabled>
                                            </div>
                                            <div class="col-sm-3 control-label">
                                                <input style="width:125px; position: relative; left: 60px;" class="form-control" type="text" value="<?php echo $d->CHR_STATUS_MC2 ?>" disabled>
                                            </div>
                                            <div class="col-sm-3 control-label">
                                                <input style="width:130px; position: relative; left: 60px;" class="form-control" id="total_mc2" type="text" value="<?php echo $d->CHR_JAM_MC2." Jam ".$d->CHR_MENIT_MC2." Menit" ?>"  disabled>
                                            </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label" style="position: relative; left:30px;"><strong>TOTAL DURATION</strong></label>
                                            <div class="col-sm-3 control-label">
                                                <input style="text-align:center; color:white; width:280px; position:relative; left:60px; background-color:red" class="form-control" id="total_duration" type="text" value="<?php echo $d->TOTAL_JAM." Jam ".$d->TOTAL_MENIT." Menit" ?>"  disabled>
                                            </div> 
                                    </div>
                                    
                                </div>
                                <div class="modal-footer">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <?php echo form_close(); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        <script>
                    $('#modaledit<?php echo $isi->CHR_TM_NUMBER; ?>').on('shown.bs.modal', function() {
                       
                    });
                </script>
          <?php
                $i++;
            }
            ?>
        
         <?php
            foreach ($duration as $d) {
                ?>
          <div class="modal fade" id="modal<?php echo $d->CHR_TM_NUMBER; ?>"  tabindex="-1" role="dialog" aria-labelledby="modaledit" aria-hidden="true" style="display: none;">
                    <div class="modal-wrapper">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                                    <h4 class="modal-title" id="modaledit"><strong>EDIT ACTUAL FINISH - <?php echo $d->CHR_TM_NUMBER; ?></strong></h4>
                                </div>
                                <div class="modal-body">
                                    <?php echo form_open('calysta/progress_c/update', 'class="form-horizontal"'); ?>
                                    <input name="CHR_TM_NUMBER" class="form-control"  type="hidden" style="width: 300px;" value="<?php echo $d->CHR_TM_NUMBER; ?>">
                                  
                                    <div class="form-group">
                                        <label class="col-sm-1 control-label" style="position: relative; left:75px;"><strong>MC1</strong></label>
                                            <div class="col-sm-3 control-label">
                                                <input name="MC1" style="width:180px; position: relative; left: 150px;" class="form-control" type="text" value="<?php echo $d->FIN_MC1 ?>" >
                                            </div>
                                    </div>
                                  
                                    <div class="form-group">
                                        <label class="col-sm-1 control-label" style="position: relative; left:75px;"><strong>SG</strong></label>
                                            <div class="col-sm-3 control-label">
                                                <input name="SG" style="width:180px; position: relative; left: 150px;" class="form-control" type="text" value="<?php echo $d->FIN_SG ?>">
                                            </div>
                                    
                                    </div>
                                   <div class="form-group">
                                        <label class="col-sm-1 control-label" style="position: relative; left:75px; "><strong>WC</strong></label>
                                            <div class="col-sm-3 control-label">
                                                <input name="WC" style="width:180px; position: relative; left: 150px;" class="form-control" type="text" value="<?php echo $d->FIN_WC ?>">
                                            </div>
                                            
                                    </div>
                                   <div class="form-group">
                                        <label class="col-sm-1 control-label" style="position: relative; left:75px;"><strong>MC2</strong></label>
                                            <div class="col-sm-3 control-label">
                                                 <input name="MC2" style="width:180px; position: relative; left: 150px;" class="form-control" type="text" value="<?php echo $d->FIN_MC2 ?>">
                                            </div>
                                           
                                    </div>
                                    
                                    
                                </div>
                               <div class="modal-footer">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Save this data"><i class="fa fa-check"></i> Update</button>

                                <?php echo form_close(); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        <script>
                    $('#modal<?php echo $isi->CHR_TM_NUMBER; ?>').on('shown.bs.modal', function() {
                       
                    });
                </script>
          <?php
                $i++;
            }
            ?>
        
        
        <script type="text/javascript" language="javascript">

function get_data(){
    var e1 = document.getElementById('e1').value;

    $.ajax({
        async: false,
        type: "POST",
        dataType: 'json',
        url: "<?php echo site_url('calysta/progress_c/get_data_dropdown'); ?>",
        data:  {
                CHR_PROJECT : e1
                },
        success: function (json_data) {
            $("#e2").html(json_data['data']);
        },
        error: function (request) {
            alert(request.responseText);
        }
    });
}
</script>
        
        
        
        
        
    </section>
</aside>

<script src="<?php echo base_url('assets/js/jquery-1.12.3.js') ?>"></script>
<script src="<?php echo base_url('assets/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?php echo base_url('assets/js/dataTables.fixedColumns.min.js') ?>"></script>
<script>
    $(document).ready(function() {
        $('#dataTables1').DataTable({
            scrollX: true,
            lengthMenu: [[10, 25, 50, 0], [10, 25, 50, "All"]],
            fixedColumns: {
                leftColumns: 2,
                rightColumns: 1                
            }
        });
    });
</script>