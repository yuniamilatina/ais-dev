
<?php $session = $this->session->all_userdata(); ?>
<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/home_c/') ?>">Home</a></li>
            <li><a href="<?php echo base_url('index.php/budget/purchase_request_c/"') ?>">Manage Purchase Request</a></li>
            <li class="active"> <a href="<?php echo base_url('index.php/budget/purchase_request_c/create_purchase_request_e"') ?>"><strong>Create Purchase Request</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <?php
        if ($msg != NULL) {
            echo $msg;
        }
        ?>
        <div class="row">

            <?php
            if ($temp_pr != NULL) {
                $this->load->view($temp_pr);
            }
            ?>
            <?php
            if ($pr_form != NULL) {
                $this->load->view($pr_form);
            }
            ?>

            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-th-large"></i>
                        <span class="grid-title"><strong><?php echo $org->CHR_SECTION ?></strong> PLANNING BUDGET  </span>
                        <div class="pull-right grid-tools">


                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div class="pull">
                            <?php echo form_open('budget/purchase_request_c/search_budget_e/', 'class="form-horizontal"'); ?>

                            <?php if ($session['ROLE'] == 1 || $session['ROLE'] == 2) { ?>

                                <select autofocus name="INT_ID_DEPT" id="selectdept" class="ddl" onchange="ChooseDept(this);" style="width:200px">
                                    <option value="0">--Select Department--</option>
                                    <?php
                                    foreach ($data_dept as $isi) {
                                        if ($dept == $isi->INT_ID_DEPT) {
                                            ?>
                                            <option selected="true" value="<?php echo $isi->INT_ID_DEPT; ?>"><?php echo $isi->CHR_DEPT . ' - ' . $isi->CHR_DEPT_DESC; ?></option>
                                        <?php } else {
                                            ?>
                                            <option value="<?php echo $isi->INT_ID_DEPT; ?>"><?php echo $isi->CHR_DEPT . ' - ' . $isi->CHR_DEPT_DESC; ?></option>
                                            <?php
                                        }
                                    }
                                    ?> 
                                </select>

                                <select name="INT_ID_SECTION" id="section" class="ddl" onchange="ChooseSection(this);" style="width:200px">
                                    <option value="0">--Select Department First--</option>
                                </select>

                                <br/>

                                <?php
                            }
                            if ($disable != 1) {
                                ?>
                                <select name="INT_ID_BUDGET_TYPE" class="ddl" style="width:250px">
                                    <option value="0">All Budget Type</option>
                                    <?php
                                    foreach ($data_type as $isi) {
                                        if ($filter == $isi->INT_ID_BUDGET_TYPE) {
                                            ?> 
                                            <option selected="true" value="<?php echo $isi->INT_ID_BUDGET_TYPE; ?>"><?php echo $isi->CHR_BUDGET_TYPE . ' / ' . $isi->CHR_BUDGET_TYPE_DESC; ?></option>
                                        <?php } else {
                                            ?>
                                            <option value="<?php echo $isi->INT_ID_BUDGET_TYPE; ?>"><?php echo $isi->CHR_BUDGET_TYPE . ' / ' . $isi->CHR_BUDGET_TYPE_DESC; ?></option>
                                            <?php
                                        }
                                    }
                                    ?> 
                                </select>

                                <button type="submit" name="search" class="btn btn-default" title="Search" data-toggle="tooltip" data-placement="right"><i class="fa fa-search"></i></button>
                            <?php } ?>
                            <?php
                            echo form_close();
                            ?>

                        </div>
                        <h4>Total <strong><?php echo $org->CHR_SECTION ?></strong>'s Budget Remains: Rp <?php echo number_format($total_remain - $temp_table_total) ?> from Rp <?php echo number_format($total_budget) ?> </h4>

                        <table id="dataTables3" class="table table-condensed table-hover table-bordered table-responsive display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>No Budget</th>
                                    <th>Budget Name</th>
                                    <th>Budget Category</th>
                                    <th>Total</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;

                                foreach ($data as $isi) {

                                    $percentage = 100;
                                    $remain = $isi->DEC_TOTAL;
                                    $selected = 0;
//                                    $selected=0;
//                                    foreach ($temp_table as $temp) {
//                                        if($isi->INT_NO_BUDGET==$temp->INT_NO_BUDGET){
//                                            $selected=1;
//                                        }
//                                    }
                                    foreach ($data_minus as $min) {
                                        if ($isi->INT_NO_BUDGET == $min->INT_NO_BUDGET) {
                                            $remain = $isi->DEC_TOTAL - $min->DEC_TOTAL;
                                            $percentage = ($remain / $isi->DEC_TOTAL) * 100;
                                        }
                                    }
                                    if ($temp_table != NULL) {
                                        foreach ($temp_table as $tp) {
                                            if ($isi->INT_NO_BUDGET == $tp->INT_NO_BUDGET) {
                                                $remain = $remain - $tp->DEC_TOTAL;
                                                $percentage = ($remain / $isi->DEC_TOTAL) * 100;
                                                $selected = 1;
                                            }
                                        }
                                    }
                                    if ($remain > 0) {
                                        $color = '';
                                        $x = 'e';
                                        if ($isi->INT_ID_UNIT != 0) {
                                            $color = 'info';
                                            $x = 's';
                                        }
                                        echo "<tr class='gradeX " . $color . "'>";
                                        echo "<td>$i</td>";
                                        echo "<td>$isi->INT_NO_BUDGET  <span class='badge bg-blue'>" . round($percentage) . "%</span></td>";
                                        echo "<td>$isi->CHR_BUDGET_NAME</td>";
                                        echo "<td>$isi->CHR_BUDGET_SUB_CATEGORY / $isi->CHR_BUDGET_SUB_CATEGORY_DESC</td>";
                                        $total = number_format($remain, 0, '', '.');
                                        echo "<td class='text-right'>$total</td>";
                                        ?>
                                    <td>
                                        <?php if ($selected == 0) { ?>
                                            <a href="<?php
                                            $full = 1;
                                            if ($percentage != 100) {
                                                $full = 0;
                                            }
                                            echo base_url('index.php/budget/purchase_request_c/add_pureq_detail_e') . "/" . $isi->INT_NO_BUDGET . "/" . $filter . "/" . $x . "/" . $full . "/";
                                            ?>" class="label label-success"><span class="fa fa-plus"></span></a>
                                            <?php } ?>

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