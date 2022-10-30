<aside class="right-side">

    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/'); ?>"><span>Home</span></a></li>
            <li><a href="<?php echo base_url('index.php/helpdesk_ticket/helpdesk_ticket_c/view_close_helpdesk_ticket'); ?>"><strong>Report Helpdesk Ticket</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <?php
        if (validation_errors()) {
            echo '<div class = "alert alert-danger"><strong>WARNING !</strong>' . validation_errors() . '</div >';
        }
        ?>

        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-ticket"></i>
                        <span class="grid-title"><strong>REPORT HELPDESK TICKET</strong> </span>
                        <div class="pull-right">
                        </div>
                    </div>

                    <div class="grid-body">
                        <div class="pull-left">
                            Report By :
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <label class="radio-inline"><input onchange="document.getElementById('dept').style.display = 'block';
                                    document.getElementById('type').style.display = 'none';" type="radio" name="radioku" checked> Department</label> &nbsp;&nbsp;&nbsp;&nbsp;
                            <label class="radio-inline"><input onchange="document.getElementById('type').style.display = 'block';
                                    document.getElementById('dept').style.display = 'none';" type="radio" name="radioku"> Type of Problem</label>
                        </div>
                        <br> <br>

                        <div id='type' style='display:none'>
                            <?php echo form_open('helpdesk_ticket/helpdesk_ticket_c/print_report_helpdesk_ticket_by_type'); ?>

                            <select name="INT_ID_PROBLEM_TYPE" onchange="ChooseProblem(this);" class="ddl" style="width:210px;">
                                <option value="">-- All Problem Type --</option>
                                <?php
                                foreach ($data_problem_type as $isi) {
                                    ?> 
                                    <option value="<?php echo $isi->INT_ID_PROBLEM_TYPE; ?>"><?php echo $isi->CHR_PROBLEM_TYPE_DESC; ?></option>
                                    <?php
                                }
                                ?> 
                            </select>
                            <select name="INT_MONTH" onchange="ChooseMonth(this);" class="ddl" style="width:160px;">
                                <option value="01">January</option>
                                <option value="02">February</option>
                                <option value="03">March</option>
                                <option value="04">April</option>
                                <option value="05">May</option>
                                <option value="06">June</option>
                                <option value="07">July</option>
                                <option value="08">August</option>
                                <option value="09">September</option>
                                <option value="10">October</option>
                                <option value="11">November</option>
                                <option value="12">December</option>
                            </select>
                            <select name="INT_YEAR" onchange="ChooseYear(this);" class="ddl" style="width:100px;">
                                <option value="2017">2017</option>
                                <option value="2018">2018</option>
                                <option value="2019">2019</option>
                                <option value="2020">2020</option>
                                <option value="2021">2021</option>
                                <option value="2022">2022</option>
                                <option value="2023">2023</option>
                            </select>
                            <div class="form-group">
                                <div class="btn-group">
                                    <br>
                                    <button type="submit" name="submit" class="btn btn-primary" data-toggle="tooltip" data-placement="right" title="Print Report"><i class="fa fa-print"></i> Print</button>
                                    <?php echo form_close(); ?>
                                </div>                            
                            </div> 
                        </div>

                        <div id='dept' style='display:block'>

                            <?php echo form_open('helpdesk_ticket/helpdesk_ticket_c/print_report_helpdesk_ticket_by_dept'); ?>

                            <select name="INT_ID_DEPT" onchange="ChooseDept(this);" class="ddl" style="width:200px;">
                                <option value="">-- All Department --</option>
                                <?php
                                foreach ($data_dept as $isi) {
                                    ?> 
                                    <option value="<?php echo $isi->INT_ID_DEPT; ?>"><?php echo $isi->CHR_DEPT_DESC; ?></option>
                                    <?php
                                }
                                ?> 
                            </select>
                            <select name="INT_MONTH" onchange="ChooseMonth(this);" class="ddl" style="width:160px;">
                                <option value="01">January</option>
                                <option value="02">February</option>
                                <option value="03">March</option>
                                <option value="04">April</option>
                                <option value="05">May</option>
                                <option value="06">June</option>
                                <option value="07">July</option>
                                <option value="08">August</option>
                                <option value="09">September</option>
                                <option value="10">October</option>
                                <option value="11">November</option>
                                <option value="12">December</option>
                            </select>
                            <select name="INT_YEAR" onchange="ChooseYear(this);" class="ddl" style="width:100px;">
                                <option value="2017">2017</option>
                                <option value="2018">2018</option>
                                <option value="2019">2019</option>
                                <option value="2020">2020</option>
                                <option value="2021">2021</option>
                                <option value="2022">2022</option>
                                <option value="2023">2023</option>
                            </select>

                            <div class="form-group">
                                <div class="btn-group">
                                    <br>
                                    <button type="submit" name="submit" class="btn btn-primary" data-toggle="tooltip" data-placement="right" title="Print Report"><i class="fa fa-print"></i> Print</button>
                                    <?php echo form_close(); ?>
                                </div>                            
                            </div>                            


                        </div>

                    </div>

                </div>
            </div>
        </div>

    </section>
</aside>