<script>
    setTimeout(function() {
        document.getElementById("hide-sub-menus").click();
    }, 30);
</script>
<style type="text/css">
    th,
    td {
        white-space: nowrap;
    }

    div.dataTables_wrapper {
        margin: 0 auto;
    }

    #table-luar {
        font-size: 12px;
    }

    #filter {
        border-spacing: 10px;
        border-collapse: separate;
    }

    .td-fixed {
        width: 30px;
    }

    .td-no {
        width: 10px;
    }

    .ddl {
        width: 100px;
        height: 30px;
    }

    .ddl2 {
        width: 180px;
        height: 30px;
    }
</style>

<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/') ?>"><span>Home</span></a></li>
            <li> <a href="#"><strong>MANAGE CAPACITY LINE</strong></a></li>
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
                        <span class="grid-title"><strong>MANAGE CAPACITY LINE</strong></span>
                        <div class="pull-right grid-tools">
                            <a href="<?php echo base_url('index.php/mrp/manage_mrp_c/create_capacity/') ?>" class="btn btn-default" data-toggle="tooltip" data-placement="left" title="Create Capacity" style="height:30px;font-size:13px;width:100px;color:#000000;">Create</a>
                        </div>
                    </div>
                    <!-- <div class="grid-body" style="padding-bottom: 0px;padding-top: 10px;">
                        <?php echo form_open('', 'class="form-horizontal"'); ?>
                        <div class="pull">
                            <table width="100%" id='filter' border=0px>
                                <tr>
                                    <td width="10%">Work Center</td>
                                    <td width="10%">
                                        <select id="e1" name="CHR_WC" class="form-control">
                                            <option value="">- Silahkan Pilih -</option>
                                            <?php
                                            foreach ($all_work_centers as $isi) {
                                            ?>
                                                <option value="<?php echo $isi->CHR_WORK_CENTER; ?>"><?php echo $isi->CHR_WORK_CENTER; ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </td>
                                    <td width="60%"><button type="submit" class="btn btn-primary" name="filter" value="1"><span class="fa fa-filter"></span>&nbsp;&nbsp;Filter</button>
                                    </td>
                                    <td width="15%"></td>
                                    <td width="20%">
                                    </td>
                                </tr>
                            </table>
                        </div>
                        </form>
                    </div> -->
                    <div class="grid-body">
                        <table id="dataTables3" class="table table-condensed table-striped table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th style='vertical-align: middle;text-align:center;'>No</th>
                                    <th style='vertical-align: middle;text-align:center;'>Line</th>
                                    <th style='vertical-align: middle;text-align:center;'>Capacity / Day</th>
                                    <th style='vertical-align: middle;text-align:center;'>Create By</th>
                                    <th style='vertical-align: middle;text-align:center;'>Create D/T</th>
                                    <th style='vertical-align: middle;text-align:center;'>Update By</th>
                                    <th style='vertical-align: middle;text-align:center;'>Update D/T</th>
                                    <th style='vertical-align: middle;text-align:center;'>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($data != NULL) {
                                    $i = 1;
                                    foreach ($data as $row) {
                                        echo "<tr class='gradeX'>";
                                        echo "<td style='text-align:center;vertical-align: middle;'>$i</td>";
                                        echo "<td style='text-align:center;vertical-align: middle;'>$row->CHR_WORK_CENTER</td>";
                                        echo "<td style='text-align:center;vertical-align: middle;'>$row->CHR_PCS_PER_DAY</td>";
                                        echo "<td style='text-align:center;vertical-align: middle;'>$row->CHR_CREATE_BY</td>";
                                        echo "<td style='text-align:center;vertical-align: middle;'>" . date("d-M-Y", strtotime($row->CHR_CREATE_DATE)) . " / " . date("H:i", strtotime($row->CHR_CREATE_TIME)) . "</td>";
                                        if ($row->CHR_UPDATE_BY == NULL) { ?>
                                            <td style='text-align:center;'></td>
                                        <?php } else { ?>
                                            <td style='text-align:center;'><?php echo $row->CHR_UPDATE_BY ?></td>
                                        <?php }
                                        if ($row->CHR_UPDATE_DATE == NULL) { ?>
                                            <td style='text-align:center;'></td>
                                        <?php } else { ?>
                                            <td style='text-align:center;'><?php echo date("d-M-Y", strtotime($row->CHR_UPDATE_DATE)) . " / " . date("H:i", strtotime($row->CHR_UPDATE_TIME)) ?></td>
                                        <?php }
                                        ?>
                                        <td style='text-align:center;'>
                                            <a href="<?php echo base_url('index.php/mrp/manage_mrp_c/edit_capacity') . '/' . trim($row->INT_ID); ?>" class="label label-warning" data-placement="top" data-toggle="tooltip" title="Edit"><span class="fa fa-pencil"></span></a>

                                        </td>
                                        </tr>
                                <?php
                                        $i++;
                                    }
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


<script>
    $('img[data-enlargable]').addClass('img-enlargable').click(function() {
        var src = $(this).attr('src');
        $('<div>').css({
            background: 'RGBA(0,0,0,.5) url(' + src + ') no-repeat center',
            backgroundSize: 'contain',
            width: '100%',
            height: '100%',
            position: 'fixed',
            zIndex: '10000',
            top: '0',
            left: '0',
            cursor: 'zoom-out'
        }).click(function() {
            $(this).remove();
        }).appendTo('body');
    });
</script>