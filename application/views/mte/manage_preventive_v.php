<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/"') ?>"><span>Home</span></a></li>
            <li> <a href="#"><strong>View Data Preventive</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-list"></i>
                        <span class="grid-title"><strong>PREVENTIVE</strong> DATA</span>
                        <!-- <div class="pull-right">
                            <a href="<?php echo base_url('index.php/asset/asset_c/create_asset/') ?>" class="btn btn-default" data-toggle="tooltip" data-placement="left" title="Create Asset" style="height:30px;font-size:13px;width:100px;">Create</a>
                        </div> -->
                    </div>
                    <div class="grid-body">
                        <table width="100%" id='filter' style="margin-bottom:-20px;">
                            <td style="vertical-align:top" width="10%">
                                <select onChange="document.location.href = this.options[this.selectedIndex].value;" class="ddl2">
                                    <?php foreach ($group_preventive as $row) { ?>
                                        <option value="<?php echo site_url('mte/preventive_schedule_c/manage_preventive/' . $row->ID); ?>" <?php
                                        if ($group == $row->ID) {
                                            echo 'SELECTED';
                                        }
                                        ?> ><?php echo trim($row->CHR_GROUP_PREVENTIVE); ?></option>
                                            <?php } ?>
                                </select>
                            </td>  
                        </table>
                    </div>
                    <div class="grid-body">
                        <table id="dataTables1" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th style='text-align: center;'>No</th>
                                    <th style='text-align: center;'>Prod Line</th>
                                    <th style='text-align: center;'>Part Name</th>
                                    <?php if($group == 1) { ?>
                                        <th style='text-align: center;'>Plan Hour Preventive</th>
                                        <th style='text-align: center;'>Running Hour</th>
                                        <th style='text-align: center;'>Remain Hour</th>
                                    <?php } else { ?>
                                        <th style='text-align: center;'>Plan Stroke Preventive</th>
                                        <th style='text-align: center;'>Running Stroke</th>
                                        <th style='text-align: center;'>Remain Stroke</th>
                                    <?php } ?>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($data as $isi) {
                                    echo "<tr class='gradeX' style='text-align: center;'>";
                                    echo "<td>$i</td>";
                                    echo "<td>$isi->CHR_WORK_CENTER</td>";
                                    echo "<td>" . trim($isi->CHR_PART_NAME) . "</td>";
                                    echo "<td>$isi->INT_STROKE_BIG_PREVENTIVE</td>";
                                    echo "<td>$isi->INT_PRODUCTION_HOUR</td>";
                                    if ($isi->INT_REMAIN < 0) {
                                        echo "<td style='background-color: red; color: white;'>$isi->INT_REMAIN</td>";
                                    } else if (($isi->INT_REMAIN > 0) && ($isi->INT_REMAIN < 100)){
                                        echo "<td style='background-color: orange; color: white;'>$isi->INT_REMAIN</td>";
                                    } else {
                                        echo "<td>$isi->INT_REMAIN</td>";
                                    }
                                    ?>
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


