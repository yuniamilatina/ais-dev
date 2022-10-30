<style type="text/css">
    th, td { white-space: nowrap; }
    div.dataTables_wrapper {
        margin: 0 auto;
    }
    #table-luar{
        font-size: 11px;
    }
    #filter { 
        /* border-spacing: 10px; */
        -webkit-border-horizontal-spacing: 0px;
        -webkit-border-vertical-spacing: 10px;
        border-collapse: separate;
    }
    .td-fixed{
        width: 30px;
    }
    .td-no{
        text-align: center;
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
            <li><a href="<?php echo base_url('index.php/basis/home_c') ?>"><span>Home</span></a></li>
            <li><a href="<?php echo base_url('index.php/basis/user_c') ?>"><strong>Manage Data Man Power</strong></a></li>
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
                        <i class="fa fa-user"></i>
                        <span class="grid-title"><strong>MANAGE DATA MAN POWER (MP)</strong></span>
                        <div class="pull-right">
                            <a href="<?php echo base_url('index.php/covid/covid_c/upload_data_mp/') ?>"  class="btn btn-default" data-placement="left" data-toggle="tooltip" title="Upload Data MP" style="height:30px;font-size:13px;width:100px;">Upload</a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div class="pull">
                            <table width="100%" id='filter'>
                                <tr>
                                    <td width="10%" style='text-align:left;' >
                                        <select onChange="document.location.href = this.options[this.selectedIndex].value;" class="ddl">
                                                <option <?php if($group == 1){echo 'selected';} ?> value="<? echo site_url('covid/covid_c/manage_data_mp/1'); ?>"> BOD</option>
                                                <option <?php if($group == 2){echo 'selected';} ?> value="<? echo site_url('covid/covid_c/manage_data_mp/2'); ?>"> PRD</option>
                                                <option <?php if($group == 3){echo 'selected';} ?> value="<? echo site_url('covid/covid_c/manage_data_mp/3'); ?>"> ENG</option>
                                                <option <?php if($group == 4){echo 'selected';} ?> value="<? echo site_url('covid/covid_c/manage_data_mp/4'); ?>"> MKT,HR,IRL,GA</option>
                                                <option <?php if($group == 5){echo 'selected';} ?> value="<? echo site_url('covid/covid_c/manage_data_mp/5'); ?>"> FAC,PUR&IMPORT</option>
                                        </select>
                                    </td>
                            </table>
                        </div>
                        <div id="table-luar">
                            <table id="dataTables2" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th style='text-align:center;'>No</th>
                                        <th style='text-align:center;'>NPK</th>
                                        <th style='text-align:center;'>Username</th>
                                        <th style='text-align:center;'>Division</th>
                                        <th style='text-align:center;'>Dept</th>
                                        <th style='text-align:center;'>Section</th>
                                        <th style='text-align:center;'>Actions</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    foreach ($data as $row) {
                                        echo "<tr class='gradeX'>";
                                        echo "<td style='text-align:center;'>$i</td>";
                                        echo "<td style='text-align:center;'>$row->CHR_NPK</td>";
                                        echo "<td style='text-align:left;'>$row->CHR_USERNAME</td>";
                                        echo "<td style='text-align:center;'>$row->CHR_DIV</td>";
                                        echo "<td style='text-align:center;'>$row->CHR_DEPT</td>";
                                        echo "<td style='text-align:center;'>$row->CHR_SECTION</td>";
                                        ?>
                                    <td  style='text-align:center;'>
                                        <a data-toggle="modal" onclick="get_detail_user('<?php echo $row->CHR_NPK ?>');" data-target="#modalEdit" class="label label-warning"  data-placement="left" title="Edit Detail User"><span class="fa fa-pencil"></span></a>
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

        <div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3" aria-hidden="true">
            <div class="modal-wrapper">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form class="form-horizontal" method="post"  role="form" action="<?php echo base_url('index.php/covid/covid_c/update_data_mp'); ?>" >
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title" id="myModalLabel3"><strong style='text-transform:uppercase;' class='case-title'></strong></h4>
                            </div>
                            <div class="modal-body" >
                                <input name="npk" class='npk' type='hidden' />
                                        
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Name</label>
                                    <div class="col-sm-6">
                                        <input class="form-control" type="text" readonly id='username'>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">PCR Result</label>
                                    <div class="col-sm-3">
                                        <select onchange='cekStatusPositive(this.value);' name='flg_pcr_positive_new' id='flg_pcr' class="form-control">
                                            <option value="0"> Negative</option>
                                            <option selected value="1"> Positive</option>
                                        </select>
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

    </section>
</aside>