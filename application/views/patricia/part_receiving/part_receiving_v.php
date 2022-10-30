<!doctype html>

<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="UNINTENTIONALACT">

        <title>Part Receiving</title>  <!--Dashboard Live : Preparation of Delivery Progress-->

        <link rel="stylesheet" href="<?php echo base_url('assets/plugins/font-awesome/css/font-awesome.min.css'); ?>" >
        <link rel="stylesheet" href="<?php echo base_url('assets/css/main_dashboard.css'); ?>" >
        <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap_dashboard.css'); ?>" >
        <link rel="shortcut icon" type="image/png" href="<?php echo base_url() ?>assets/img/binoculars_115194.ico"/>
        
        <script type="text/javascript" src="<?php echo base_url('assets/js/jquery-latest.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/js/bootstrap.js'); ?>" ></script>
        <script type="text/javascript" src="<?php echo base_url('assets/js/ism-2.2.min.js'); ?>"></script>
    </head>
    <body class="body-layout" style="color:#FAFAFA; background-color:#1F1F1F;">
        <div class="navbar-nav navbar-inverse navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <a class="navbar-brand" href="#"><img src="<?php echo base_url('assets/img/logo30.png'); ?>" alt=""></a>
                </div> 
               
                <ul class="nav navbar-brand-clock">
                    <li >
                        <label style='color:white;font-weight:600;font-size: 1.5em;' >PART RECEIVING</label>
                    </li>
                </ul>
            </div>
        </div>

        <h1 style='padding-top:25px;'><span class='white'></span></h1>

        <table class="container-table" id="table" >
            <tr>
                <th class='grey'>
                    No
                </th>
                <th class='grey'>
                    PDS Number
                </th>
                <th class='grey' width="20%">
                    Supplier
                </th>
                <th class='grey'>
                    Date
                </th>
                <th class='grey'>
                    Time
                </th>
                <th class='grey'>
                    Back No
                </th>
                <th class='grey'>
                    Part Number
                </th>
                <th class='grey'>
                    Part Name
                </th>
                <th class='grey'>
                    Rak 
                </th>
                <th class='grey'>
                    Quantity
                </th>
                <th class='grey'>
                    Status
                </th>
              
            </tr>
            
            <?php $i=1; foreach ($data as $row){ ?>
                <tr>
                    <td  style='text-align: center;cursor: pointer; cursor: hand;'>
                        <?php echo $i; ?>
                    </td>
                    <td style='text-align: center;cursor: pointer; cursor: hand;'>
                        <?php echo $row->CHR_PDS_NUMBER; ?>
                    </td>
                    <td href='#<?php echo $i; ?>' data-toggle='modal' style='text-align: center;cursor: pointer; cursor: hand;'>
                        <?php echo $row->CHR_NAMA_VENDOR; ?>
                    </td>
                    <td href='#<?php echo $i; ?>' data-toggle='modal' style='text-align: center;cursor: pointer; cursor: hand;'>
                        <?php echo date("d-m", strtotime($row->CHR_CREATED_DATE)); ?>
                    </td>
                    <td href='#<?php echo $i; ?>' data-toggle='modal' style='text-align: center;cursor: pointer; cursor: hand;'>
                        <?php echo date("H:i", strtotime($row->CHR_CREATED_TIME)); ?>
                    </td>
                    <td href='#<?php echo $i; ?>' data-toggle='modal' style='text-align: center;cursor: pointer; cursor: hand;'>
                        <?php echo $row->CHR_BACK_NO; ?>
                    </td>
                    <td href='#<?php echo $i; ?>' data-toggle='modal' style='text-align: center;cursor: pointer; cursor: hand;'>
                        <?php echo $row->CHR_PART_NO; ?>
                    </td>
                    <td href='#<?php echo $i; ?>' data-toggle='modal' style='text-align: center;cursor: pointer; cursor: hand;'>
                        <?php echo $row->CHR_NAMA_PART; ?>
                    </td>
                    <td href='#<?php echo $i; ?>' data-toggle='modal' style='text-align: center;cursor: pointer; cursor: hand;'>
                        <?php echo $row->CHR_RAKNO; ?>
                    </td>
                    <td href='#<?php echo $i; ?>' data-toggle='modal' style='text-align: center;cursor: pointer; cursor: hand;'>
                        <?php echo $row->INT_QUANTITY.' Pcs'; ?>
                    </td>
                    <?php 
                        if($row->CHR_STATUS == 'Unchecked'){
                    ?>
                        <td class='bgblue' >
                            <?php echo $row->CHR_STATUS; ?>
                        </td>
                    <?php }else if($row->CHR_STATUS == 'Checked'){ ?>
                        <td class='bggreen'  >
                            <?php echo $row->CHR_STATUS; ?>
                        </td>
                    <?php }else if($row->CHR_STATUS == 'OK'){ ?>
                        <td class='bggreen'  >
                            <?php echo $row->CHR_STATUS; ?>
                        </td>
                    <?php }else if($row->CHR_STATUS == 'NG' || $row->CHR_STATUS == 'Same Lot'){ ?>
                        <td class='bgorange'  >
                            <?php echo $row->CHR_STATUS; ?>
                        </td>
                    <?php }else{ ?>
                        <td class='bgred' style='color:#FFFFFF;' >
                            <?php echo $row->CHR_STATUS; ?>
                        </td>
                    <?php } ?>
                   
                </tr>
            <?php $i++; } ?>
            
        </table>

        <?php $x=1; foreach ($data as $row){ ?>
            <div class='modal fade' id='<?php echo $x; ?>' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
                <div class='modal-dialog'>    
                    <div class='modal-content'>        
                        <div class='modal-header'>            
                            <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>            
                            <h4 class='modal-title' id='modal-title-1'><?php echo 'PDS NO : ' .$row->CHR_PDS_NUMBER; ?></h4>        
                        </div>
                        <?php
                            echo form_open('patricia/part_receiving_c/update_load_number', 'class="form-horizontal"');
                        ?>
                        <div class='modal-body'>

                            <div class='form-group'>
                                <label class="col-sm-3 control-label">PDS No</label>
                                <div class="col-sm-4">
                                    <input type="text" name="CHR_PDS_NUMBER" readonly class="form-control" value='<?php echo trim($row->CHR_PDS_NUMBER) ?>'>
                                </div>
                            </div>

                            <div class='form-group'>
                                <label class="col-sm-3 control-label">Part No</label>
                                <div class="col-sm-4">
                                    <input type="text" name="CHR_PART_NO" readonly class="form-control" value='<?php echo trim($row->CHR_PART_NO) ?>'>
                                </div>
                            </div>

                            <div class='form-group'>
                                <label class="col-sm-3 control-label">Load Number</label>
                                <div class="col-sm-6">
                                    <textarea rows="4" cols="50" type="text" name="CHR_LOAD_NUMBER" class="form-control" autocomplete=off required ><?php echo trim($row->CHR_LOAD_NUMBER) ?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class='modal-footer'>         
                            <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Submit</button>
                            <button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>        
                        </div>
                        <?php
                            echo form_close();
                        ?>
                    </div>
                </div>
            </div>
        
        <?php $x++; } ?>
            
    </body>

</html>



