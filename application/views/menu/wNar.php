<?php include(APPPATH . 'views/wHeader.php') ?>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
    .row-full {
        width: 100%;
        margin: 0px;
        padding: 0px;
    }

    .Titlebar {
        padding: 10px;
        color: #ffffff;
    }

    .login-box {
        margin-top: 100px;
    }

    .login-title {
        text-align: center;
    }

    .more-info {
        padding-left: 0px;
        padding-right: 0px;
        padding-top: 0px;
        padding-bottom: 10px;
        font-size: 12px;
        color: red;
    }

    .swal-button--confirm {
        background-color: #0a53be !important;
    }
</style>
<title>Reset Password</title>
<div class="container-fluid">
    <div class="row">
        <div class="col bg-dark Titlebar">
        Reset Password
        </div>

        <div class="col bg-dark Titlebar ">
            <div class="row">
                <!-- <div class="col bg-dark  text-end" style="padding-right:0 !important">
                   
                </div> -->
                <div class="col text-end">
               
                  
                  
                    <?php echo get_cookie('TaskEmail'); ?>
                  
                </div>
            </div>
        </div>
    </div>
<div class="text-center">
    <div>ล้างรหัสผ่านเรียบร้อย</dvi>
<div>
    <a href="<?php echo base_url('index.php/home');?>">กลับหน้าหลัก</a>
</div>
</div>

