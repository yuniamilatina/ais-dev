<div class="grid" ><!--style="background-color: #94D1DC"-->
    <div class="grid-header">
        <i class="fa fa-user"></i>
        <span class="grid-title"><strong>NG Login</strong> Scan Id Card Anda</span>
    </div>

    <div class="grid-body">
    <center>
        <img src="<?php echo base_url('assets/img/user/user_icon.png'); ?>" width="300px" >
        <div class="clear-fix"></div>
        <div class="ng-screen-login">
                <form method="POST" action="<?php echo site_url('pes/ng_no_locking/check')?>">
                    <input type="text" style="margin-top: 20px;width: 200px" name="CHR_NPK" placeholder="NIK"></input>
                </form>
           </form>
        </div>
    </center>
    </div>
</div>